/**
 * File to change active link in sidebar admin
 */
$(document).ready(function () {
    var host = window.location.host;
    var path = window.location.pathname;
    var href = host + path;

    var regexApprove = new RegExp('^' + host + '/admin/approve');
    var regexCategory = new RegExp('^' + host + '/admin/categories');
    var regexProduct = new RegExp('^' + host + '/admin/products');
    var regexUser = new RegExp('^' + host + '/admin/(users|staff)');
    var regexInvoice = new RegExp('^' + host + '/admin/invoices');

    $('li.nav-link').removeClass('active');
    if (regexApprove.test(href)) {
        $('li#approve-link').addClass('active');
    } else if (regexCategory.test(href)) {
        $('li#category-link').addClass('active');
    } else if (regexProduct.test(href)) {
        $('li#product-link').addClass('active');
    } else if (regexUser.test(href)) {
        $('#user-type').show();
        var regex = new RegExp('^' + host + '/admin/users');
        if(regex.test(href)){
            $('#customer-link').addClass('active-link');
        } else {
            $('#staff-link').addClass('active-link');
        }
        $('li#user-link').addClass('active');
    } else if (regexInvoice.test(href)) {
        $('#invoices-status').show();
        var inProgress = new RegExp('^' + host + '/admin/invoices/in-progress');
        var inTransport = new RegExp('^' + host + '/admin/invoices/in-transport');
        var inSuccess = new RegExp('^' + host + '/admin/invoices/in-success');
        var inCancel = new RegExp('^' + host + '/admin/invoices/in-canceled');
        if (inProgress.test(href)) {
            $('#progress-link').addClass('active-link');
        } else if (inTransport.test(href)) {
            $('#transport-link').addClass('active-link');
        } else if (inSuccess.test(href)) {
            $('#success-link').addClass('active-link');
        } else if (inCancel.test(href)) {
            $('#cancel-link').addClass('active-link');
        }
        $('li#invoice-link').addClass('active');
    } else {
        $('li#dashboard-link').addClass('active');
    }

});
