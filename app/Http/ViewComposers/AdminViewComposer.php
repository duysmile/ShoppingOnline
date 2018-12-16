<?php
/**
 * Created by PhpStorm.
 * User: duy21
 * Date: 11/28/2018
 * Time: 10:27 PM
 */

namespace App\Http\ViewComposers;

use App\Model\Invoice;
use Illuminate\View\View;

class AdminViewComposer
{
    /**
     * attach data to view
     * @param View $view
     */
    public function compose(View $view)
    {
        $countInvoices = Invoice::countInvoices();
        $view->with('countInvoices', $countInvoices);
    }
}
