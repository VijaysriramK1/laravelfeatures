<?php

use App\Http\Controllers\AddAmountController;
use App\Http\Controllers\AdmissionFeesController;
use Illuminate\Support\Facades\Route;
use Modules\Fees\Http\Controllers\AjaxController;
use Modules\Fees\Http\Controllers\FeesController;
use Modules\Fees\Http\Controllers\FeesReportController;
use Modules\Fees\Http\Controllers\StudentFeesController;

Route::group(['middleware' => ['subdomain']], function () {
    Route::prefix('fees')->middleware('auth')->group(function () {
        //Fees Group
        Route::get('fees-group', [FeesController::class, 'feesGroup'])->name('fees.fees-group')->middleware('userRolePermission:fees.fees-group');
        Route::post('fees-group-store', [FeesController::class, 'feesGroupStore'])->name('fees.fees-group-store')->middleware('userRolePermission:fees.fees-group-store');
        Route::get('fees-group-edit/{id}', [FeesController::class, 'feesGroupEdit'])->name('fees.fees-group-edit');
        Route::post('fees-group-update', [FeesController::class, 'feesGroupUpdate'])->name('fees.fees-group-update')->middleware('userRolePermission:fees.fees-group-edit');
        Route::post('fees-group-delete', [FeesController::class, 'feesGroupDelete'])->name('fees.fees-group-delete')->middleware('userRolePermission:fees.fees-group-delete');

        //Fees Type
        Route::get('fees-type', [FeesController::class, 'feesType'])->name('fees.fees-type')->middleware('userRolePermission:fees.fees-type');
        Route::post('fees-type-store', [FeesController::class, 'feesTypeStore'])->name('fees.fees-type-store')->middleware('userRolePermission:fees.fees-type-store');
        Route::get('fees-type-edit/{id}', [FeesController::class, 'feesTypeEdit'])->name('fees.fees-type-edit');
        Route::post('fees-type-update', [FeesController::class, 'feesTypeUpdate'])->name('fees.fees-type-update')->middleware('userRolePermission:fees.fees-type-edit');
        Route::post('fees-type-delete', [FeesController::class, 'feesTypeDelete'])->name('fees.fees-type-delete')->middleware('userRolePermission:fees.fees-type-delete');

        //Fees invoice
        Route::get('fees-invoice-list', [FeesController::class, 'feesInvoiceList'])->name('fees.fees-invoice-list')->middleware('userRolePermission:fees.fees-invoice-list');
        Route::get('fees-invoice', [FeesController::class, 'feesInvoice'])->name('fees.fees-invoice');
        Route::post('fees-invoice-store', [FeesController::class, 'feesInvoiceStore'])->name('fees.fees-invoice-store')->middleware('userRolePermission:fees.fees-invoice-store');
        Route::get('fees-invoice-edit/{id}', [FeesController::class, 'feesInvoiceEdit'])->name('fees.fees-invoice-edit');
        Route::post('fees-invoice-update', [FeesController::class, 'feesInvoiceUpdate'])->name('fees.fees-invoice-update')->middleware('userRolePermission:fees.fees-invoice-edit');
        Route::get('fees-invoice-view/{id}/{state}', [FeesController::class, 'feesInvoiceView'])->name('fees.fees-invoice-view');
        Route::post('fees-invoice-delete', [FeesController::class, 'feesInvoiceDelete'])->name('fees.fees-invoice-delete')->middleware('userRolePermission:fees.fees-invoice-delete');
        Route::post('fees-payment-store', [FeesController::class, 'feesPaymentStore'])->name('fees.fees-payment-store')->middleware('userRolePermission:fees.add-fees-payment');
        Route::get('single-payment-view/{id}/{type}', [FeesController::class, 'singlePaymentView'])->name('fees.single-payment-view');
        Route::get('add-fees-payment/{id}', [FeesController::class, 'addFeesPayment'])->name('fees.add-fees-payment')->middleware('userRolePermission:fees.add-fees-payment');
        Route::get('delete-single-fees-transcation/{id}', [FeesController::class, 'deleteSingleFeesTranscation'])->name('fees.delete-single-fees-transcation');
        Route::get('fees-invoice-datatable', [FeesController::class, 'feesInvoiceDatatable'])->name('fees.fees-invoice-datatable');


        //Admission Fees
        Route::get('admissionfees-amount', [AdmissionFeesController::class, 'Admissionfessview'])->name('admission_fees');
        Route::post('admissionfees-invoice-post', [AdmissionFeesController::class, 'Store'])->name('fees.fees-invoice-post');
        Route::get('/admissionfees-amount/edit/{id}', [AdmissionFeesController::class, 'edit'])->name('edit-amount');
        Route::post('/admissionfees-amount/update/{id}', [AdmissionFeesController::class, 'update'])->name('update-amount');
        Route::get('/admissionfees-amount/delete/{id}', [AdmissionFeesController::class, 'destroy'])->name('delete-amount');
        //Admission Fees invoice
        Route::get('admission-fees-invoice-list', [AdmissionFeesController::class, 'admissionfeesInvoiceList'])->name('admissionfees-invoice-list');
        Route::get('/admissioninvoicefees-amount/edit/{id}', [AdmissionFeesController::class, 'Admissioninvoiceedit'])->name('admissioninvoice-edit-amount');
        Route::post('/admissioninvoicefees-amount/update/{id}', [AdmissionFeesController::class, 'Admissioninvoiceupdate'])->name('admissioninvoice-update-amount');
        Route::post('admission-fees-invoice-delete', [AdmissionFeesController::class, 'admissionfeesInvoiceDelete'])->name('admissionfees-invoice-delete');
        Route::get('admission-fees-invoice-view/{id}/{state}', [AdmissionFeesController::class, 'admissionfeesInvoiceView'])->name('fees.admissionfees-invoice-view');
        Route::get('admin-fees-payment/{id}', [AdmissionFeesController::class, 'adminAddFeesPayment'])->name('fees.admin-fees-payment');
        Route::post('admission-payment-store', [AdmissionFeesController::class, 'admissionpayment'])->name('admissionfesspayment');
        Route::get('admission-fees-invoice-datatable', [AdmissionFeesController::class, 'admissionfeesInvoiceDatatable'])->name('fees.admission-fees-invoice-datatable');
        Route::get('admission-payment-view/{id}/{type}', [AdmissionFeesController::class, 'admissionPaymentView'])->name('fees.admission-payment-view');
        Route::get('admission-delete-single-fees-transcation/{id}', [AdmissionFeesController::class, 'admissionDeleteSingleFeesTranscation'])->name('fees.admission-delete-single-fees-transcation');

        //Bank Payment
        Route::get('bank-payment', [FeesController::class, 'bankPayment'])->name('fees.bank-payment')->middleware('userRolePermission:fees.bank-payment');
        Route::post('search-bank-payment', [FeesController::class, 'searchBankPayment'])->name('fees.search-bank-payment')->middleware('userRolePermission:fees.search-bank-payment');
        Route::post('approve-bank-payment', [FeesController::class, 'approveBankPayment'])->name('fees.approve-bank-payment')->middleware('userRolePermission:fees.approve-bank-payment');
        Route::post('reject-bank-payment', [FeesController::class, 'rejectBankPayment'])->name('fees.reject-bank-payment')->middleware('userRolePermission:fees.reject-bank-payment');

        //Fees invoice Settings
        Route::get('fees-invoice-settings', [FeesController::class, 'feesInvoiceSettings'])->name('fees.fees-invoice-settings')->middleware('userRolePermission:fees.fees-invoice-settings');
        Route::post('fees-invoice-settings-update', [FeesController::class, 'ajaxFeesInvoiceSettingsUpdate'])->name('fees.fees-invoice-settings-update')->middleware('userRolePermission:fees.fees-invoice-settings-update');

        //Fees Report
        Route::get('due-fees', [FeesReportController::class, 'dueFeesView'])->name('fees.due-fees')->middleware('userRolePermission:fees.due-fees');
        Route::post('search-due-fees', [FeesReportController::class, 'dueFeesSearch'])->name('fees.search-due-fees');
        Route::get('fine-report', [FeesReportController::class, 'fineReportView'])->name('fees.fine-report')->middleware('userRolePermission:fees.fine-report');
        Route::post('fine-search', [FeesReportController::class, 'fineReportSearch'])->name('fees.fine-search');
        Route::get('payment-report', [FeesReportController::class, 'paymentReportView'])->name('fees.payment-report')->middleware('userRolePermission:fees.payment-report');
        Route::post('payment-search', [FeesReportController::class, 'paymentReportSearch'])->name('fees.payment-search');
        Route::get('balance-report', [FeesReportController::class, 'balanceReportView'])->name('fees.balance-report')->middleware('userRolePermission:fees.balance-report');
        Route::post('balance-search', [FeesReportController::class, 'balanceReportSearch'])->name('fees.balance-search');
        Route::get('waiver-report', [FeesReportController::class, 'waiverReportView'])->name('fees.waiver-report')->middleware('userRolePermission:fees.waiver-report');
        Route::post('waiver-search', [FeesReportController::class, 'waiverReportSearch'])->name('fees.waiver-search');
        Route::get('fees-report-datatable', [FeesReportController::class, 'feesReportDatatable'])->name('fees.fees-report-datatable')->middleware('userRolePermission:fees.payment-report');

        // Student
        Route::get('student-fees-list/{id}', [StudentFeesController::class, 'studentFeesListParent'])->name('fees.student-fees-list-parent')->middleware('userRolePermission:fees.student-fees-list-parent');
        Route::get('student-fees-list', [StudentFeesController::class, 'studentFeesList'])->name('fees.student-fees-list')->middleware('userRolePermission:fees.student-fees-list');
        Route::get('student-fees-payment/{id}', [StudentFeesController::class, 'studentAddFeesPayment'])->name('fees.student-fees-payment');
        Route::post('student-fees-payment-store', [StudentFeesController::class, 'studentFeesPaymentStore'])->name('fees.student-fees-payment-store');

        //Ajax Request
        Route::post('fees-view-payment', [AjaxController::class, 'feesViewPayment'])->name('fees.fees-view-payment')->middleware('userRolePermission:fees.fees-view-payment');
        Route::post('admission-fees-view-payment', [AjaxController::class, 'admissionfeesViewPayment'])->name('fees.admission-fees-view-payment');

        Route::post('select-fees-type', [AjaxController::class, 'ajaxSelectFeesType'])->name('fees.select-fees-type');
        Route::get('ajax-get-all-section', [AjaxController::class, 'ajaxGetAllSection'])->name('fees.ajax-get-all-section');
        Route::get('ajax-section-all-student', [AjaxController::class, 'ajaxSectionAllStudent'])->name('fees.ajax-section-all-student');
        Route::get('/fetch-students', [AjaxController::class, 'fetchStudents'])->name('fetch-students');
        Route::get('/fetch-category-students', [AjaxController::class, 'fetchcategoryStudents'])->name('fetch-category-students');
        Route::get('/get-groups', 'AjaxController@getGroups')->name('get.groups');

        Route::get('ajax-get-all-student', [AjaxController::class, 'ajaxGetAllStudent'])->name('fees.ajax-get-all-student');
        Route::post('change-method', [AjaxController::class, 'changeMethod'])->name('fees.change-method');
        Route::post('admission-change-method', [AjaxController::class, 'admissionChangeMethod'])->name('fees.admission-change-method');
        Route::get('gateway-service-charge', [AjaxController::class, 'serviceCharge'])->name('gateway-service-charge');
    });  
    Route::get('section-to-group', [AjaxController::class, 'sectionToGroup'])->name('section-to-group');
    Route::get('group-to-category', [AjaxController::class, 'groupToCategory'])->name('group-to-category');


});
