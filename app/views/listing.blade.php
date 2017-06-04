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

  @if($section == 'users')
  <div class="col-md-3 col-sm-6 col-xs-12" style="clear:both;">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Users</span>
        <span class="info-box-number">{{ count($list) }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  @endif
   
  <section class="content-header">
    <h1 style="text-transform: uppercase;">
      {{ $section }} Management
    @if($section != 'users' && $section != 'witness')
      <button type="button" class="btn btn-success pull-right" style="margin-bottom: 1%;" onclick="window.location='{{ url($section.'/add') }}'">
          <i class="glyphicon glyphicon-plus"></i> Add </button>
    @endif
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            @if($section == 'prevention')
             <table id="listingTable" class="table table-bordered table-hover" style="table-layout: auto;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Subtitle</th>
                  <th>Date</th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($list as $list)
                <tr>
                  <td style="width:2%; white-space: nowrap; text-align:center;">{{ $list->id }}</td>
                  <td>{{ $list->title }}</td>
                  <td>{{ $list->subtitle }}</td>
                  <td>{{ $list->date }}</td>
                  <td id="view" style="width:15px;"><a class="btn btn-info" href="{{ URL::to($section.'/view/'.$list->id) }}"><i class="glyphicon glyphicon-info-sign"></i></a></td>
                  <td id="edit" style="width:15px;"><a class="btn btn-warning" href="{{ URL::to($section.'/edit/'.$list->id) }}"><i class="glyphicon glyphicon-edit"></i></a></td>
                  <td id="del" style="width:15px;"><a class="btn btn-danger" onclick="del({{ $list->id }})"><i class="glyphicon glyphicon-trash"></a></td>
                </tr>
                @endforeach 
              </tbody>
            </table>
            @elseif($section == 'reports')
            <table id="listingTable" class="table table-bordered table-hover" style="table-layout: auto;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Date</th>
                  <th>Route</th>
                  <th>State</th>
                  <th>City</th>
                  <th>Type</th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($list as $list)
                <tr>
                  <td style="width:2%; white-space: nowrap; text-align:center;">{{ $list->id }}</td>
                  <td>{{ $list->reportDT }}</td>
                  <td>{{ $list->route }}</td>
                  <td>{{ $list->state }}</td>
                  <td>{{ $list->city }}</td>
                  <td>{{ $list->type }}</td>
                  <td id="view" style="width:15px;"><a class="btn btn-info" href="{{ URL::to($section.'/view/'.$list->id) }}"><i class="glyphicon glyphicon-info-sign"></i></a></td>
                  <td id="edit" style="width:15px;"><a class="btn btn-warning" href="{{ URL::to($section.'/edit/'.$list->id) }}"><i class="glyphicon glyphicon-edit"></i></a></td>
                  <td id="del" style="width:15px;">
                    <a class="btn btn-danger" onclick="del({{ $list->id }})"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @elseif($section == 'witness')
            <table id="listingTable" class="table table-bordered table-hover" style="table-layout: auto;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User ID</th>
                  <th>Date &amp; Time</th>
                  <th>Route</th>
                  <th>State</th>
                  <th>City</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($list as $list)
                <tr>
                  <td style="width:2%; white-space: nowrap; text-align:center;">{{ $list->id }}</td>
                  <td style="width:2%; white-space: nowrap; text-align:center;">{{ $list->userID }}</td>
                  <td>{{ $list->incidentDT }}</td>
                  <td>{{ $list->route }}</td>
                  <td>{{ $list->state }}</td>
                  <td>{{ $list->city }}</td>
                  <td>{{ $list->type }}</td>
                  <td>{{ $list->status }}</td>
                  <td id="view" style="width:15px;"><a class="btn btn-info" href="{{ URL::to($section.'/view/'.$list->id) }}"><i class="glyphicon glyphicon-info-sign"></i></a></td>
                  <td id="edit" style="width:15px;"><a class="btn btn-warning" href="{{ URL::to($section.'/edit/'.$list->id) }}"><i class="glyphicon glyphicon-edit"></i></a></td>
                  <td id="del" style="width:15px;">
                    <a class="btn btn-danger" onclick="del({{ $list->id }})"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                </tr>
                @endforeach 
              </tbody>
            </table>
            @elseif($section == 'users')
            <table id="listingTable" class="table table-bordered table-hover" style="table-layout: auto;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($list as $list)
                <tr>
                  <td style="width:2%; white-space: nowrap; text-align:center;">{{ $list->id}}</td>
                  <td>{{ $list->name }}</td>
                  <td>{{ $list->hpnum }}</td>
                  <td>{{ $list->email }}</td>
                  <td id="view" style="width:15px;"><a class="btn btn-info" href="{{ URL::to($section.'/view/'.$list->id) }}"><i class="glyphicon glyphicon-info-sign"></i></a></td>
                  <td id="del" style="width:15px;">
                    <a class="btn btn-danger" onclick="del({{ $list->id }})"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                </tr>
                @endforeach 
              </tbody>
            </table>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

<script>
  function del(id){
    if (confirm("Confirm delete?") == true) {
      var url = "<?php echo $section ?>/delete/"+id;
      window.location = url;
    } 
  }
</script>
@endsection