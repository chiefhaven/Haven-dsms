@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Edit Invoice {{$invoice->invoice_number}}</h1>
        <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb"></nav>
      </div>
    </div>
  </div>

  <div class="content content-full">
    @if(Session::has('message'))
            <div class="alert alert-success">
              {{Session::get('message')}}
            </div>
          @endif

          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
    <div class="block block-rounded">
    <div class="block-content">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <form class="mb-5" action="{{ url('/invoice-update') }}" method="POST">
                        @csrf
                        <input type="text" name="invoice_number" id="invoice_number" value="{{$invoice->invoice_number}}" hidden> 
                    <div class="row">  
                        <div class="col-6 form-floating mb-4">
                            <select class="form-select" id="student" name="student">
                                <option value="{{$invoice->student->fname}} {{$invoice->student->mname}} {{$invoice->student->sname}}"><strong>{{$invoice->student->fname}} {{$invoice->student->sname}}</strong></option>
                            </select>
                            <label for="example-ltf-email">Select student</label>
                        </div>
                        <div class="col-3 form-floating mb-4">
                            <input type="datetime-local" class="form-control" id="date_created" name="date_created" placeholder="Enter invoice date" value="{{$invoice->date_created}}">
                            <label for="invoice_discount">Date</label>
                        </div>
                        <div class="col-3 form-floating mb-4">
                            <input type="datetime-local" class="form-control" id="invoice_due_date" name="invoice_due_date" placeholder="Enter invoice due date" value="{{$invoice->invoice_payment_due_date}}">
                            <label for="invoice_discount">Invoice Due Date</label>
                        </div>
                    </div>
                    <div class="col-12 form-floating mb-4">
                        <select class="form-select" id="course" name="course">
                          @foreach($course as $course_option)
                            <option value="{{$course_option->name}}" {{ $course_option->id == $invoice->course_id ? 'selected' : '' }}><strong>{{$course_option->name}}</strong> (K{{$course_option->price}})</option>
                          @endforeach
                        </select>
                        <label for="district">Course To Enroll</label>
                    </div>
                    <div class="col-12 form-floating mb-4">
                        <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter discount (Fixed)" value="{{$invoice->invoice_discount}}">
                        <label for="invoice_discount">Discout</label>
                    </div>
                    <div class="row">
                        <div class="col-6 form-floating mb-4">
                            <input type="number" class="form-control" id="paid_amount" name="paid_amount" placeholder="Enter discount (Fixed)" value="{{$invoice->invoice_amount_paid}}">
                            <label for="invoice_discount">Amount Paid</label>
                        </div>
                        <div class="col-6 form-floating mb-4">
                            <select class="form-select" id="payment_method" name="payment_method">                              
                                <option value="cash" selected>Cash</option>
                            </select>
                            <label for="district">Payment Method</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
  </div>
  <!-- END Hero -->

@endsection
