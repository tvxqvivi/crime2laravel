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
        <h3 class="box-title" style="text-transform: uppercase;">Add New {{ $section }}</h3>
  </div>

  @if($section == 'prevention')
    {{ Form::open(array('url' => $section.'/add','method' => 'POST','class' =>'form-horizontal','files' => true)) }}
      <div class="box-body">
        <p class="mandatory">* Please fill in mandatory fields</p>
        <div class="form-group">
          <label for="title" class="col-sm-2 control-label"><span class="mandatory">* </span>Title</label>
          <div class="col-sm-10">
            <input class="form-control" name="title" type="text" placeholder="Title" id="title" value="{{ Input::old('title') }}" required>
          </div>
        </div>
        <div class="form-group">
          <label for="subtitle" class="col-sm-2 control-label">Subtitle</label>
          <div class="col-sm-10">
            <input class="form-control" name="subtitle" type="text" placeholder="Subtitle" id="subtitle" value="{{ Input::old('subtitle') }}">
          </div>
        </div>
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label"><span class="mandatory">* </span>Description</label>
          <div class="col-sm-10">
            <div class="box">
              <div class="pull-right box-tools"></div>
              <div class="box-body pad">
                <textarea class="textarea" name="description" id="description" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>{{ Input::old('desc')}}</textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="author" class="col-sm-2 control-label"><span class="mandatory">* </span>Author</label>
          <div class="col-sm-10">
            <input class="form-control" name="author" type="text" placeholder="Author" id="author" value="{{ Input::old('author')}}" required>
          </div>
        </div>
        <div class="form-group">
          <label for="date" class="col-sm-2 control-label"><span class="mandatory">* </span>Date</label>
          <div class="col-sm-10 date">
            <input type="date" class="form-control" name="date" id="date" required>
          </div>
        </div>
        <div class="form-group">
          <label for="text" class="col-sm-2 control-label"><span class="mandatory">* </span>Source</label>
          <div class="col-sm-10">
            <input class="form-control" name="source" type="text" placeholder="Source" id="source" value="{{ Input::old('source')}}" required>
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
    {{ Form::open(array('url' => $section.'/add','method' => 'POST','class' =>'form-horizontal','files' => true)) }}
      <div class="box-body">
        <p class="mandatory">* Please fill in mandatory fields</p>
        <div class="form-group">
          <label for="date" class="col-sm-2 control-label"><span class="mandatory">* </span>Report Date</label>
          <div class="col-sm-10 date"><input type="date" class="form-control" name="date" id="date" required></div>
        </div>
        <div class="form-group">
          <label for="latlng" class="col-sm-2 control-label">Latitude and Longitude</label>
          <div class="col-sm-4"><input type="text" class="form-control" name="lat" id="lat" placeholder="Latitude" value="{{ Input::old('latitude')}}"></div>
          <div class="col-sm-4"><input type="text" class="form-control" name="lng" id="lng" placeholder="Longitude" value="{{ Input::old('longitude')}}"></div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-primary pull-right" onclick="getReverseGeocodingData()">
          <i class="glyphicon glyphicon-map-marker"></i> Locate </button>
          </div>
        </div>
        <div class="form-group">
          <label for="route" class="col-sm-2 control-label"><span class="mandatory">* </span>Route</label>
          <div class="col-sm-10">
            <input class="form-control" name="route" type="text" placeholder="Route" id="route" value="{{ Input::old('route')}}" required>
          </div>
        </div>
        <div class="form-group">
          <label for="state" class="col-sm-2 control-label"><span class="mandatory">* </span>State</label>
          <div class="col-sm-10">
            <input class="form-control" name="state" type="text" placeholder="State" id="state" value="{{ Input::old('state')}}" required>
          </div>
        </div>
        <div class="form-group">
          <label for="city" class="col-sm-2 control-label"><span class="mandatory">* </span>City</label>
          <div class="col-sm-10">
            <input class="form-control" name="city" type="text" placeholder="City" id="city" value="{{ Input::old('city')}}" required>
          </div>
        </div>
        <div class="form-group">
          <label for="postcode" class="col-sm-2 control-label">Postal Code</label>
          <div class="col-sm-10">
            <input class="form-control" name="postcode" type="text" placeholder="Postal Code" id="postcode" value="{{ Input::old('postcode')}}">
          </div>
        </div>
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10">
            <div class="box">
              <div class="pull-right box-tools"></div>
              <div class="box-body pad">
                <textarea class="textarea" name="description" id="description" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ Input::old('description')}}</textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="type" class="col-sm-2 control-label"><span class="mandatory">* </span>Type</label>
          <div class="col-sm-10">
            <select class="form-control" name="type" id="type" required>
              <option>Select a Type</option>
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
  @endif
@endsection
