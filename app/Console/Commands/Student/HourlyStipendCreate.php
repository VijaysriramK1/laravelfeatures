<?php

namespace App\Console\Commands\Student;

use Carbon\Carbon;
use App\Models\Stipend;
use App\Models\StipendPayment;
use Illuminate\Console\Command;

class HourlyStipendCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:hourly-stipend-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Student hourly stipend create';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $check_stipend = Stipend::whereMonth('start_date', '<=', Carbon::now()->month)->whereYear('start_date', '<=', Carbon::now()->year)->where('interval_type', 'hourly')->get();

        if ($check_stipend->isNotEmpty()) {
            $check_stipend_payment = StipendPayment::whereIn('stipend_id', $check_stipend->pluck('id'))->get();
            $current_date = Carbon::now()->format('Y-m-d');
            $start_date_of_this_month = Carbon::now()->startOfMonth()->format('Y-m-d');

            if ($current_date == $start_date_of_this_month) {
                foreach ($check_stipend as $get_values) {
                    $get_count = $check_stipend_payment->where('stipend_id', $get_values->id)->count();

                    if ($get_count < $get_values->cycle_count) {
                        $get_stipend_id[] = $get_values->id;
                    } else {
                        $get_stipend_id[] = null;
                    }
                }
            } else {
                $get_stipend_id[] = null;
            }
        } else {
            $get_stipend_id[] = null;
        }

        foreach ($get_stipend_id as $stipend_id) {
            if ($stipend_id != null) {
                $get_stipend_details = $check_stipend->where('id', $stipend_id)->first();

                $add_stipend_payment = new StipendPayment();
                $add_stipend_payment->stipend_id = $stipend_id;
                $add_stipend_payment->student_id = $get_stipend_details->student_id;
                $add_stipend_payment->stipends_amount = $get_stipend_details->amount;
                $add_stipend_payment->created_date = Carbon::now()->format('Y-m-d');
                $add_stipend_payment->save();
            } else {
            }
        }
        return response()->json(['status' => 'success']);
    }
}
