@extends('layout.admin')

@section('content')

  @if ($errors->has())
    <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        @foreach ($errors->all() as $error)
          {{ $error }}<br>        
        @endforeach
    </div>
  @endif

  @if (Session::has('success'))
    <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
  @endif

  @if (Session::has('failed'))
    <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('failed') }}
    </div>
  @endif

  <div class="row">
    <div class="col-md-12">
      <!-- Profile Image -->
      <div class="box box-primary">
      @if($section == "users")
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ $view->img }}" alt="{{ $view->id }}">
          <h3 class="profile-username text-center">{{ $view->name }}</h3>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-6"><b>Email</b></div>
                <div class="col-xs-6"><span>{{ $view->email }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-6"><b>I/C Number</b></div>
                <div class="col-xs-6"><span>{{ $view->ic }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-6"><b>Gender</b></div>
                <div class="col-xs-6"><span>{{ $view->gender }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-6"><b>Contact Number</b></div>
                <div class="col-xs-6"><span>{{ $view->hpnum }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-6"><b>Address</b></div>
                <div class="col-xs-6"><span>{{ $view->address }}</span></div>
              </div>
            </li>
          </ul>
          <a href="{{ URL::to($section) }}"><b>Back to User List</b></a>
        </div>
        <!-- /.box-body -->
      @elseif($section == "prevention")
        <div class="box-body">
          <div class="container">
            <div class="row">
              <div class="col-xs-3 thumbnail preventionCon">
                  <img class="preventionIMG" src="{{ $view->imgURL1 }}" alt="{{ $view->id }}">
              </div>
              <div class="col-xs-3 thumbnail preventionCon">
                  <img class="preventionIMG" src="{{ $view->imgURL2 }}" alt="{{ $view->id }}">
              </div>
              <div class="col-xs-3 thumbnail preventionCon">
                  <img class="preventionIMG" src="{{ $view->imgURL3 }}" alt="{{ $view->id }}">
              </div>
            </div>
          </div>
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Title</b></div>
                <div class="col-xs-10"><span>{{ $view->title }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Subtitle</b></div>
                <div class="col-xs-10"><span>{{ $view->subtitle }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Description</b></div>
                <div class="col-xs-10"><span>{{ $view->desc }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Author</b></div>
                <div class="col-xs-10"><span>{{ $view->author }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Date</b></div>
                <div class="col-xs-10"><span>{{ $view->date }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Source</b></div>
                <div class="col-xs-10"><a href="{{ $view->source }}">{{ $view->source }}</a></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Video</b></div>
                <div class="col-xs-10">
                  <video id="prevideo" width="480" height="360" controls>
                    <source src="{{ $view->vidURL }}">
                  </video>
                </div>
              </div>
            </li>
          </ul>
          <a href="{{ URL::to($section) }}"><b>Back to Prevention Tips List</b></a>
        </div>
        <!-- /.box-body -->
        @elseif($section == "witness")
        <div class="box-body">
          <div class="thumbnail">
              <img class="preventionIMG" src="{{ $view->img }}" alt="{{ $view->id }}">
          </div>
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>User ID</b></div>
                <div class="col-xs-10"><span>{{ $view->userID }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Incident Date and Time</b></div>
                <div class="col-xs-10"><span>{{ $view->incidentDT }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Latitude and Longitude</b></div>
                <div class="col-xs-5"><span>{{ $view->latitude }}</span></div>
                <div class="col-xs-5"><span>{{ $view->longitude }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>State</b></div>
                <div class="col-xs-10"><span>{{ $view->state }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>City</b></div>
                <div class="col-xs-10"><span>{{ $view->city }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Postal Code</b></div>
                <div class="col-xs-10"><span>{{ $view->postcode }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Type</b></div>
                <div class="col-xs-10"><span>{{ $view->type }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Description</b></div>
                <div class="col-xs-10"><span>{{ $view->desc }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>status</b></div>
                <div class="col-xs-10"><span>{{ $view->status }}</span></div>
              </div>
            </li>
          </ul>
          <a href="{{ URL::to($section) }}"><b>Back to Witnessed Incident List</b></a>
        </div>
        <!-- /.box-body -->
        @elseif($section == "reports")
        <div class="box-body">
          <div class="thumbnail">
              <img class="preventionIMG" src="{{ $view->img }}" alt="{{ $view->id }}">
          </div>
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Report Date</b></div>
                <div class="col-xs-10"><span>{{ $view->reportDT }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Latitude and Longitude</b></div>
                <div class="col-xs-5"><span>{{ $view->latitude }}</span></div>
                <div class="col-xs-5"><span>{{ $view->longitude }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>State</b></div>
                <div class="col-xs-10"><span>{{ $view->state }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>City</b></div>
                <div class="col-xs-10"><span>{{ $view->city }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Postal Code</b></div>
                <div class="col-xs-10"><span>{{ $view->postcode }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Type</b></div>
                <div class="col-xs-10"><span>{{ $view->type }}</span></div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="row">
                <div class="col-xs-2"><b>Description</b></div>
                <div class="col-xs-10"><span>{{ $view->desc }}</span></div>
              </div>
            </li>
          </ul>
          <a href="{{ URL::to($section) }}"><b>Back to Crime Report List</b></a>
        </div>
        <!-- /.box-body -->
      @endif
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

<script type="text/javascript">
  $(".thumbnail").find("img[src='']").parent().hide();
  $("#prevideo").find("source[src='']").parent().hide();
</script>

@endsection