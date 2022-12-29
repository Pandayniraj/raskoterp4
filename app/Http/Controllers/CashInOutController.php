<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashInOutController extends Controller
{
    

	public function cash(){

		if(\Request::get('start_date') && \Request::get('end_date')){

			$start_date = \Request::get('start_date');

			$end_date = \Request::get('end_date');

		}else{

			$start_date = date('Y-m-d');

			$end_date = date('Y-m-d');

		}
		$types = ['customer_payment'=>'Customer Payment', 'customer_advance'=>'Customer Advance', 'sales_without_invoice'=>'Sales Without Invoice', 'other_income'=>'Other Income', 'interest_income'=>'Interest Income'];



		$payment = \App\Models\Payment::where('payments.date','>=',$start_date)
					->where('payments.date','<=',$end_date)
					->join('entries', 'payments.entry_id', '=', 'entries.id')
					->get();

		$bankingIncome = \App\Models\BankIncome::where('bank_income.date_received','>=',$start_date)
					->where('bank_income.date_received','<=',$end_date)
					->join('entries', 'bank_income.entry_id', '=', 'entries.id')
					->get();

		$expenses = \App\Models\Expense::where('expenses.date','>=',$start_date)
					->where('expenses.date','<=',$end_date)
					->join('entries', 'expenses.entry_id', '=', 'entries.id')
					->get();

		$orders = \App\Models\Orders::where('fin_orders.bill_date','>=',$start_date)
					->where('fin_orders.bill_date','<=',$end_date)
					->where('fin_orders.order_type','proforma_invoice')
					->join('entries', 'fin_orders.entry_id', '=', 'entries.id')
					->get();
					
		$purhcase = \App\Models\PurchaseOrder::where('purch_orders.bill_date','>=',$start_date)
					->where('purch_orders.bill_date','<=',$end_date)
					->join('entries', 'purch_orders.entry_id', '=', 'entries.id')
					->get();


		//dd($expenses);

	//					dd($bankingIncome);

		$page_title = 'Day Book & Cash Flow';
		$page_description = 'Cash In Out Lsit';
		return view('admin.cashinout.list',compact('payment','bankingIncome','expenses','types','page_title','start_date','end_date','orders','purhcase','page_description'));


	}




}
