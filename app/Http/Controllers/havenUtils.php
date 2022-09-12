<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Course;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\District;
use App\Models\Lesson;
use App\Models\Attendance;
use App\Models\Invoice_Setting;

class havenUtils extends Controller
{
    static function studentID($studentName){

        $student_name = explode(" ", $studentName);
        $studentnameCount = count($student_name);

        if($studentnameCount = 2){

            $student = Student::where('fname', $student_name[0])->where('sname',$student_name[2])->first();

            if(!is_null($student)){

                return $student->id;
            }

            else{

                return null;
            }
        }

        elseif($studentnameCount = 3){

            $student = Student::where('fname', $student_name[0])->where('mname',$student_name[1])->where('sname',$student_name[2])->first();

            if(!is_null($student)){

                return $student->id;
            }

            else{

                return null;
            }
        }

        else{

            return null;

        }

    }

    static function instructorID($instructorName){

        $instructor_name = explode(" ", $instructorName);

        $instructor = Instructor::where('fname', $instructor_name[0])->where('sname',$instructor_name[1])->firstOrFail();
        return $instructor->id;
    }

    
    static function courseID($courseName){

        $course = Course::where('name', $courseName)->firstOrFail();
        return $course->id;
    }

    static function invoiceDiscountedPrice($courseName, $discount){

        $course = Course::where('name', $courseName)->firstOrFail();
        $discount = $discount;
        $total_price = $course->price - $discount;
        return $total_price;
    }

    static function coursePrice($courseName){

        $course = Course::where('name', $courseName)->firstOrFail();
        return $course->price;
    }



    static function invoiceTotal($courseName, $invoiceDiscount){

        $course = Course::where('name', $courseName)->firstOrFail();

        $invoiceTotal = $course->price-$invoiceDiscount;
        return $invoiceTotal;
    }

    static function invoiceBalance($paidAmount, $invoiceTotal){

        $invoiceBalance = $invoiceTotal - $paidAmount;
        return $invoiceBalance;
    }


    static function selectDistrict($district){

        $district = District::where('name', $district)->firstOrFail();
        return $district->id;
    }

    static function lessonID($lessonName){

        $lesson = Lesson::where('name', $lessonName)->firstOrFail();
        return $lesson->id;
    }

    static function attendancePercent($studentID){

        $course_id = Student::where('id', $studentID)->firstOrFail()->course_id;

        if(!is_null($course_id)){

            $courseDuration = self::courseDuration($course_id);
            $attendanceCount = Attendance::where('student_id', $studentID)->count();

            if($attendanceCount > 0){

                $attendancePercent = $attendanceCount/$courseDuration*100;
            }

            else{

                $attendancePercent = 0;
            }
        }

        else{

            $attendancePercent = 0;
        }

        
        return number_format((integer)$attendancePercent);
    }

    //check for course Duration a students is enrolled in based on current invoice
    static function courseDuration($course_id){

        $courseDuration = Course::where('id', $course_id)->firstOrFail()->duration;
        return $courseDuration;
    }

    //Generate invoice number
    static function generateInvoiceNumber(){

        $LatestInvoice = Invoice::max('id');

        if(isset($LatestInvoice)){

            $highestInvoiceNumber = Invoice::where('id', $LatestInvoice)->firstOrFail()->invoice_number;
            $invoiceNumberOnly = substr($highestInvoiceNumber, -5);
            $newInvoiceNumber =++ $invoiceNumberOnly;
        }

        else{

            $newInvoiceNumber = sprintf("%05d", 1);

        }
        

        $prefix = Invoice_Setting::find(1)->prefix;

        $useYear = Invoice_Setting::find(1)->year;

        if(isset($prefix) && $useYear == 1){
            $invoiceNumber = $prefix.'-'.date('Y').'-'.$newInvoiceNumber;
        }

        else {
            $invoiceNumber = 'Invoice-'.$newInvoiceNumber;
        }

        return $invoiceNumber;
    }


}
