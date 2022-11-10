@extends('master')


@section('content')

@section('topbar')
    @parent
@endsection {{-- end: topbar --}}

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="right_col" role="main">
    <div class="home-header text-center">
        <h1 class="center">Welcome to the Facts Application</h1>
        <strong>Please select one of the options below </strong><br>
        <br><br>
    </div>
    <!-- Checks if response is there from PUT request -->
    @if (session()->get( 'request' ))
      <div class="alert alert-success">Fact submitted successfully<br><br>
      {{ session()->get( 'request' ) }}
      
      </div>
    @endif
    <div class="row">
      <div class="col-lg-4 col-md-12" >
          <div class="card shadow mb-4" style="min-height: 360px;">
            <!-- Card Header  -->
            <div class="card-header py-3 d-flex flex-row align-items-center text-center justify-content-between">
                <h2 class="m-0 font-weight-bold text-primary ">Random fact</h2>
            </div>
            <!-- Card Body -->
            <div class="card-body">
            <p>Click on the button below to reveal a random fact.</p>
                <button id="random" class="btn btn-primary">Random</button>
            </div>
          </div>
      </div>
  
      <div class="col-lg-4 col-md-12" >
        <div class="card shadow mb-4" style="min-height: 360px;">
            <!-- Card Header  -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h2 class="m-0 font-weight-bold text-primary ">Random Historic</h2>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="container mt-5" style="max-width: 450px">
                  <form>
                    <div class="row form-group">
                        <label for="date" class="col-form-label">Pick a month and day to find a random historic fact:</label>
                        <div class="col-sm-6">
                          <div class="input-group date" id="datepicker">
                              <input type="text" id="dateValue" class="form-control">
                              <span class="input-group-append">
                              <span class="input-group-text bg-white d-block">
                              <i class="fa fa-calendar"></i>
                              </span>
                              </span>
                          </div>
                        </div>
                    </div>
                  </form>
              </div>
          </div>
  </div>
</div>
 <!-- Submit private fact  -->
  <div class="col-lg-4 col-md-12" >
    <div class="card shadow mb-4" style="min-height: 360px;">
      <!-- Card Header  -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h2 class="m-0 font-weight-bold text-primary">Submit a private fact</h2>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <form action="/random/store" method="POST" id="createFact" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    
        <div class="form-group row mb-2">
          <label for=""class="col-sm-4 col-form-control">The fact</label>
          <div class="col-sm-8">
            <input name="fact" id='fact' type="text"" class="form-control @error('fact') is-invalid @enderror" value="" required autofocus>
          </div>
        </div>

        <div class="form-group row mb-2">
          <label for=""class="col-sm-4 col-form-control">Catagory</label>
          <div class="col-sm-8">
          <input name="category" id='category' type="text"" class="form-control @error('category') is-invalid @enderror" value="" required autofocus>
          </div>
        </div>

        <div class="form-group row mb-2">
          <label for=""class="col-sm-4 col-form-control">Subcatagory</label>
          <div class="col-sm-8">
          <input name="subcategory" id='subcategory' type="text"" class="form-control @error('subcategory') is-invalid @enderror" value="" required autofocus>
          </div>
        </div>

        <div class="form-group row mb-2">
          <label for=""class="col-sm-4 col-form-control">Add a tag</label>
          <div class="col-sm-8">
          <input name="tag" id='tag' type="text"" class="form-control @error('tag') is-invalid @enderror" value="" required autofocus>
          </div>
        </div>
       <button id="submitFact" class="float-right btn btn-primary">Submit</button>
      </form>
     </div>
    </div>
</div>
    <div class="col-lg-4 col-md-12" >
    <div class="card shadow mb-4" style="min-height: 360px;">
      <!-- Card Header  -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h2 class="m-0 font-weight-bold text-primary">Show a private fact</h2>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <form id="getFact">    
        <div class="form-group row mb-2">
          <label for="" class="col-sm-4 col-form-control">Please enter the fact ID:</label>
          <div class="col-sm-8">
            <input name="privateFact" id="privateFact" type="text"" class="form-control form-control-sm" value="">
          </div>
        </div>
       <button id="submitPrivateFact" class="float-right btn btn-primary">Submit</button>
        </form>
     </div>
    </div>

 <!-- Bootstrap fact display modal  -->
      <div class="modal fade" id="factModal" tabindex="-1" role="dialog" aria-labelledby="factModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content"  style="width:700px;min-height:650px;">
            <div class="modal-header">

              <h5 class="modal-title" id="factModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div id="factOutput" class="text-center"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

// datepicker enable and format
    $.fn.datepicker.dates.en.titleFormat="MM";
    $(function() {
      $('#datepicker').datepicker({
          format: 'dd-mm',
          autoclose: true,
          startView: 1,
          maxViewMode: "months",
          orientation: "bottom left",     
      });
    });

$(document).ready(function() {



  // gets date value when input and passes to controller
  $('#dateValue').change(function(){

    var historicDates = $(this).val();
    $.get('/randomhistoric/show/' + historicDates, function(response) {
      $('#factModal').modal('show');
      $('#factOutput').html("<h3 class='text-center'>Your Random Historic Fact</h3><h4>On " + response['day'] + ' ' + response['month'] + ' ' + response['year'] + '</h4>'+ "<div class='card text-bg-info mb-3 mt-3 pt-4 pb-4 center' style=''>" + response['event'] + "</div>" );
    });
  });

  // random fact generator
  $('#random').click(function(){
    $.get('/random/show/' , function(response) {
      console.log(response);
      $('#factModal').modal('show');
      $('#factOutput').html("<h3 class='text-center'>Your Random Fact</h3><div class='card text-bg-info mb-3 mt-3 pt-4 pb-4 center' style=''><h4>Catagory: " + response['category'] + "</h4><h5>Subcatagory: " + response['subcategory'] + "</h5><strong>" + response['fact'] + "</strong></div>" );
    });
  });

  $("#getFact").submit(function(e) {
    e.preventDefault();
});
    // Get private
  $('#submitPrivateFact').click(function(){
    var id = $('#privateFact').val();
    $.get('/random/private/' + id , function(response) {
      console.log(response);
      $('#factModal').modal('show');
      $('#factOutput').html("<h3 class='text-center'>Your Fact</h3><div class='card text-bg-info mb-3 mt-3 pt-4 pb-4 center' style=''><h4>Catagory: " + response['category'] + "</h4><h5>Subcatagory: " + response['subcategory'] + "</h5><strong>" + response['fact'] + "</strong></div>" );
    });
  });
});
</script>

@endsection 