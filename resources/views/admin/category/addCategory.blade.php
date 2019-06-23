@extends('admin.master')

@section('title')
	Add Category
@endsection

@section('mainContent')

<br>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="column">
                <a href="{{ url('/category/manage') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Category </a>
            </div>
        </div>
    </div>
    <br>
	<div class="card">
		<div class="card-body">
			<div class="card-title"> <i class="fa fa-plus"></i> Add Category</div>
			<hr>				   
			{!! Form::open(['url' => '/category/save','method'=>'post']) !!}
				<div class="row">
			      	<div class="col-sm-2" role="alert"></div>
             	</div>
				<div class="form-group row">
					<label for="input-4" class="col-sm-2 col-form-label">Category Name :</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="input-4" required="" name="categoryName" placeholder="Enter category name">
					</div>
				</div>
				<div class="form-group row">
					<label for="input-1" class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-primary shadow-primary px-5"></i> Save</button>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection