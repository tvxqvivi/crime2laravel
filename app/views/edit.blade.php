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

  <div class="box-header with-border" style="border-bottom: 1px solid #CBCECE !important;">
        <h3 class="box-title" style="text-transform: uppercase;">Edit {{ $section }} : {{$id}}</h3>
  </div>

  @if($section == 'prevention')
    {{ Form::open(array('url' => $section.'/edit/'.$id,'method' => 'POST','class' =>'form-horizontal','files' => true)) }}
      <div class="box-body">

        <div class="form-group">
          <label for="title" class="col-sm-2 control-label">Title</label>
          <div class="col-sm-10">
            <input class="form-control" name="title" type="text" id="title" value="{{ Input::old('title') ? Input::old('title') : $edit->title }}">
          </div>
        </div>
        <div class="form-group">
          <label for="subtitle" class="col-sm-2 control-label">Subtitle</label>
          <div class="col-sm-10">
            <input class="form-control" name="subtitle" type="text" id="subtitle" value="{{ Input::old('subtitle') ? Input::old('subtitle') : $edit->subtitle }}">
          </div>
        </div>
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10">
            <div class="box">
              <div class="pull-right box-tools"></div>
              <div class="box-body pad">
                <textarea class="textarea" name="description" id="description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" value="{{ Input::old('desc') ? Input::old('desc') : $edit->desc }}"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="author" class="col-sm-2 control-label">Author</label>
          <div class="col-sm-10">
            <input class="form-control" name="author" type="text" id="author" value="{{ Input::old('author') ? Input::old('author') : $edit->author }}">
          </div>
        </div>
        <div class="form-group">
          <label for="date" class="col-sm-2 control-label">Date</label>
          <div class="col-sm-10 date">
            <input type="date" class="form-control" name="date" id="date" value="{{ Input::old('date') ? Input::old('date') : $edit->date }}">
          </div>
        </div>
        <div class="form-group">
          <label for="text" class="col-sm-2 control-label">Source</label>
          <div class="col-sm-10">
            <input class="form-control" name="source" type="text" id="source" value="{{ Input::old('source') ? Input::old('source') : $edit->source }}">
          </div>
        </div>
        <div class="form-group">
          <label for="vidURL" class="col-sm-2 control-label">Video</label>
          <div class="col-sm-10">
            <input type="file" id="vidURL" name="vidURL"></div>
        </div>

        <div class="form-group">
          <label for="imgURL1" class="col-sm-2 control-label">Image 1</label>
          <div class="col-sm-10">
            <input type="file" id="imgURL1" name="imgURL1">
          </div>
        </div>
        <div class="form-group">
          <label for="imgURL2" class="col-sm-2 control-label">Image 2</label>
          <div class="col-sm-10">
            <input type="file" id="imgURL2" name="imgURL2">
          </div>
        </div>
        <div class="form-group">
          <label for="imgURL3" class="col-sm-2 control-label">Image 3</label>
          <div class="col-sm-10">
            <input type="file" id="imgURL3" name="imgURL3">
          </div>
        </div>
      
      </div>
      
       <div class="box-footer" style="background-color: rgba(255, 255, 255, 0) !important; border-top: 1px solid #CBCECE !important;">
        <button type="button" class="btn" onclick="window.location='{{ url($section) }}'">Cancel</button>
        <button type="submit" id="btn-submit" class="btn pull-right">Save</button>
      </div>
    {{ Form::close() }}
  @elseif($section == 'reports')
    {{ Form::open(array('url' => $section.'/edit/'.$id,'method' => 'POST','class' =>'form-horizontal','files' => true)) }}
      <div class="box-body">
        <div class="form-group">
          <label for="date" class="col-sm-2 control-label">Report Date</label>
          <div class="col-sm-10">
            <input class="form-control" name="date" type="date" id="date" value="{{ Input::old('reportDT') ? Input::old('reportDT') : $edit->reportDT }}">
          </div>
        </div>
        <div class="form-group">
          <label for="latlng" class="col-sm-2 control-label">Latitude and Longitude</label>
          <div class="col-sm-4"><input type="text" class="form-control" name="lat" id="lat" value="{{ Input::old('latitude') ? Input::old('latitude') : $edit->latitude }}"></div>
          <div class="col-sm-4"><input type="text" class="form-control" name="lng" id="lng" value="{{ Input::old('longitude') ? Input::old('longitude') : $edit->longitude }}"></div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-primary pull-right" onclick="getReverseGeocodingData()">
          <i class="glyphicon glyphicon-map-marker"></i> Locate </button>
          </div>
        </div>
        <div class="form-group">
          <label for="route" class="col-sm-2 control-label">Route</label>
          <div class="col-sm-10">
            <input class="form-control" name="route" type="text" id="route" value="{{ Input::old('route') ? Input::old('route') : $edit->route }}">
          </div>
        </div>
        <div class="form-group">
          <label for="state" class="col-sm-2 control-label">State</label>
          <div class="col-sm-10">
            <input class="form-control" name="state" type="text" id="state" value="{{ Input::old('state') ? Input::old('state') : $edit->state }}">
          </div>
        </div>
        <div class="form-group">
          <label for="city" class="col-sm-2 control-label">City</label>
          <div class="col-sm-10">
            <input class="form-control" name="city" type="text" id="city" value="{{ Input::old('city') ? Input::old('city') : $edit->city }}">
          </div>
        </div>
        <div class="form-group">
          <label for="postcode" class="col-sm-2 control-label">Postal Code</label>
          <div class="col-sm-10">
            <input class="form-control" name="postcode" type="text" id="postcode" value="{{ Input::old('postcode') ? Input::old('postcode') : $edit->postcode }}">
          </div>
        </div>
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10">
            <div class="box">
              <div class="pull-right box-tools"></div>
              <div class="box-body pad">
                <textarea class="textarea" name="description" id="description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" value="{{ Input::old('desc') ? Input::old('desc') : $edit->desc }}"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="type" class="col-sm-2 control-label">Type</label>
          <div class="col-sm-10">
            <select class="form-control" name="type" id="type">
              <option value="{{ Input::old('type') ? Input::old('type') : $edit->type }}">{{ Input::old('type') ? Input::old('type') : $edit->type }}</option>
              <option value="Assault">Assualt</option>
              <option value="Homicide">Homicide</option>
              <option value="Kidnapping">Kidnapping</option>
              <option value="Robbery">Robbery</option>
              <option value="Sexual_Offense">Sexual Offense</option>
              <option value="Breaking_Entering">Breaking and Entering</option>
              <option value="Theft">Theft</option>
              <option value="Theft_Vehicle">Theft from Vehicle</option>
              <option value="Drugs">Drugs</option>
              <option value="Liquor">Liquor</option>
              <option value="Others">Others</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="img" class="col-sm-2 control-label">Image</label>
          <div class="col-sm-10">
            <input type="file" id="img" name="img">
          </div>
        </div>
      </div>
      
       <div class="box-footer" style="background-color: rgba(255, 255, 255, 0) !important; border-top: 1px solid #CBCECE !important;">
        <button type="button" class="btn" onclick="window.location='{{ url($section) }}'">Cancel</button>
        <button type="submit" id="btn-submit" class="btn pull-right">Save</button>
      </div>
    {{ Form::close() }}
  @elseif($section == 'witness')
    {{ Form::open(array('url' => $section.'/edit/'.$id,'method' => 'POST','class' =>'form-horizontal','files' => true)) }}
      <div class="box-body">
        <div class="form-group">
          <label for="status" class="col-sm-2 control-label">Status</label>
          <div class="col-sm-10">
            <input class="form-control" name="status" type="text" id="status" value="{{ Input::old('status') ? Input::old('status') : $edit->status }}">
          </div>
        </div>
      </div>
      <div class="box-footer" style="background-color: rgba(255, 255, 255, 0) !important; border-top: 1px solid #CBCECE !important;">
        <button type="button" class="btn" onclick="window.location='{{ url($section) }}'">Cancel</button>
        <button type="submit" id="btn-submit" class="btn pull-right">Save</button>
      </div>
    {{ Form::close() }}
  @endif

<script type="text/javascript">
  $("#type option").val(function(idx,val){
    $(this).siblings("[value='"+ val +"']").remove();
  });
</script>

@endsection
