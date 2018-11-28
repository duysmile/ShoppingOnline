<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $laptop = new \App\Model\Category();
        $laptop->name = 'Laptop';
        $laptop->slug = str_slug('Laptop');
        $laptop->top = true;
        $laptop->created_user = 2;
        $laptop->save();

        $smart = new \App\Model\Category();
        $smart->name = 'Điện thoại di động';
        $smart->slug = str_slug('Điện thoại di động');
        $smart->top = true;
        $smart->created_user = 2;
        $smart->save();

        $tv = new \App\Model\Category();
        $tv->name = 'TV';
        $tv->slug = str_slug('TV');
        $tv->top = true;
        $tv->created_user = 2;
        $tv->save();

        $speaker = new \App\Model\Category();
        $speaker->name = 'Loa & tai nghe';
        $speaker->slug = str_slug('Loa & tai nghe');
        $speaker->top = false;
        $speaker->created_user = 2;
        $speaker->save();

        $pc = new \App\Model\Category();
        $pc->name = 'Chuột, bàn phím & phụ kiện';
        $pc->slug = str_slug('Chuột, bàn phím & phụ kiện');
        $pc->top = false;
        $pc->created_user = 2;
        $pc->save();

        $dell = new \App\Model\Category();
        $dell->name = 'Dell';
        $dell->slug = 'Dell';
        $dell->top = false;
        $dell->parent_id = 1;
        $dell->created_user = 2;
        $dell->save();

        $asus = new \App\Model\Category();
        $asus->name = 'Asus';
        $asus->slug = str_slug('Asus');
        $asus->top = false;
        $asus->parent_id = 1;
        $asus->created_user = 2;
        $asus->save();

        $hp = new \App\Model\Category();
        $hp->name = 'HP';
        $hp->slug = str_slug('HP');
        $hp->top = false;
        $hp->parent_id = 1;
        $hp->created_user = 2;
        $hp->save();

        $mac = new \App\Model\Category();
        $mac->name = 'Macbook';
        $mac->slug = str_slug('Macbook');
        $mac->top = false;
        $mac->parent_id = 1;
        $mac->created_user = 2;
        $mac->save();

        $iphone = new \App\Model\Category();
        $iphone->name = 'Iphone';
        $iphone->slug = str_slug('Iphone');
        $iphone->top = false;
        $iphone->parent_id = 2;
        $iphone->created_user = 2;
        $iphone->save();

        $lg = new \App\Model\Category();
        $lg->name = 'LG';
        $lg->slug = str_slug('LG');
        $lg->top = false;
        $lg->parent_id = 2;
        $lg->created_user = 2;
        $lg->save();

        $samsung = new \App\Model\Category();
        $samsung->name = 'Samsung';
        $samsung->slug = str_slug('Samsung');
        $samsung->top = false;
        $samsung->parent_id = 2;
        $samsung->created_user = 2;
        $samsung->save();

        $xiao = new \App\Model\Category();
        $xiao->name = 'Xiaomi';
        $xiao->slug = str_slug('Xiaomi');
        $xiao->top = false;
        $xiao->parent_id = 2;
        $xiao->created_user = 2;
        $xiao->save();

        $huawei = new \App\Model\Category();
        $huawei->name = 'Huawei';
        $huawei->slug = str_slug('Huawei');
        $huawei->top = false;
        $huawei->parent_id = 2;
        $huawei->created_user = 2;
        $huawei->save();
    }
}
