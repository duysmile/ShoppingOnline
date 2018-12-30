<?php

namespace App\Model;

use App\Mail\VerifyEmail;
use App\Permission\HasPermissionsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;
    use HasPermissionsTrait;
    use SoftDeletes;

    protected $dates = ['is_blocked'];
    const DELETED_AT = 'is_blocked';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * attach info to user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(InfoUser::class, 'user_id', 'id');
    }

    /**
     * attach social account
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function socialAccount()
    {
        return $this->hasOne('App\Model\SocialAccount');
    }

    /**
     * attach verify attribute
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function verifyUser()
    {
        return $this->hasOne('App\Model\VerifyUser');
    }

    /**
     * attach cart to user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id', 'id');
    }

    /**
     * attach password reset attribute
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function passwordReset()
    {
        return $this->hasOne('App\Model\PasswordReset');
    }

    /**
     * Sign up user
     * @param $request
     */
    public static function signUp($request, $role)
    {
        DB::beginTransaction();
        try {
            $tmp = $request->only(['email', 'password', 'username', 'tel']);
            $user = [
                'name' => $tmp['username'],
                'email' => $tmp['email'],
                'password' => Hash::make($tmp['password'])
            ];
            $user_created = User::create($user);
            InfoUser::create([
                'user_id' => $user_created->id,
                'tel_no' => $tmp['tel']
            ]);
            VerifyUser::create([
                "user_id" => $user_created->id,
                "token" => $user_created->id . str_random(30) . time()
            ]);
            $user_role = Role::where('slug', $role)->first();
            $user_created->roles()->attach($user_role);

            Mail::to($user_created->email)->send(new VerifyEmail($user_created));
            DB::commit();
            return [
                "success" => true,
                "message" => "Chúng tôi đã gửi email xác thực. Kiểm tra email và xác nhận."
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return [
                "success" => false,
                "message" => [
                    "server" => "Đăng kí thất bại. Vui lòng thử lại."
                ],
                "data" => $request->only(['email', 'username', 'tel'])
            ];
        }
    }

    /**
     * verify email
     * @param $token
     * @return array
     */
    public static function verifyEmail($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if ($user->email_verified_at == null) {
                $user->email_verified_at = date('Y-m-d H:i:s', time());
                $user->save();
                $status = "Bạn đã xác thực email thành công. Bây giờ bạn có thể đăng nhập.";
            } else {
                $status = "Bạn đã xác thực email rồi. Bây giờ bạn có thể đăng nhập.";
            }
            return [
                'success' => true,
                'status' => $status
            ];
        }
        return [
            'success' => false,
            'status' => 'Xin lỗi không thể tìm thấy email tài khoản của bạn.'
        ];
    }

    /**
     * update information of user
     * @param $request
     * @return array
     */
    public static function updateProfile($request)
    {
        $data = $request->only(['tel', 'address', 'gender', 'birth_date', 'name', 'email']);

        $data['gender'] = $data['gender'] == 'true' ? true : false;
        try {
            $user = Auth::user();
            if ($user->info == null) {
                InfoUser::create([
                    'user_id' => $user->id,
                    'tel_no' => $data['tel'],
                    'address' => $data['address'],
                    'gender' => $data['gender'],
                    'birth_date' => Carbon::createFromFormat('Y-m-d', $data['birth_date'])->toDateString(),
                    'name' => $data['name']
                ]);
            } else {
                $info = $user->info();
                $info->update([
                    'tel_no' => $data['tel'],
                    'address' => $data['address'],
                    'gender' => $data['gender'],
                    'birth_date' => Carbon::createFromFormat('Y-m-d', $data['birth_date'])->toDateString(),
                    'name' => $data['name']
                ]);
            }
            return [
                'success' => true,
                'message' => 'Lưu thông tin thành công.'
            ];
        } catch (\Exception $e) {
            dd($e);
            return [
                'success' => false,
                'message' => 'Đã xảy ra lỗi. Vui lòng thử lại.' . $e
            ];
        }
    }

    /**
     * get all user according role
     * @param $role
     * @return mixed
     */
    public static function getUserByRole($role)
    {
        $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('slug', $role);
        })
            ->whereNotNull('email_verified_at')
            ->orderBy('created_at')
            ->paginate(constants('PAGINATE.USERS'));
        return $users;
    }
}
