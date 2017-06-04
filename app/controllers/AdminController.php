<?php
header('Access-Control-Allow-Origin: *');
class AdminController extends BaseController {

	public function login(){
		return View::make("login");
	}

	public function register(){
		return View::make("register");
	}

	public function checkregister(){
		$rules = array(
			'name' => 'required',
	    'email'  => 'required|email|unique:admin,email',
	    'password' 	=> 'required|confirmed',
	    'password_confirmation' => 'required',
	    'hpnum' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}
		else
		{	
			$password = Input::get('password');

			$admin = New Admin;
			$admin->name = Input::get('name');
			$admin->email = Input::get('email');
			$admin->password = Hash::make($password);
			$admin->hpnum = Input::get('hpnum');

			if($admin->save())
				return Redirect::to('/')->with('message','Successfully registered.');
			else
				return Redirect::back()->withErrors('Registration failed. Please try again.');
		}
	}

	public function checklogin(){
		$rules = array(
	    'email'  => 'email|required',
	    'password' 	=> 'required'
		);

		$validator = Validator::make(Input::all(), $rules);
		$email = Input::get('email');

		if($validator->fails())
		{
		    return Redirect::to('/')->withErrors($validator);
		}
		else
		{		
			$isAdmin = Admin::where('email',$email)->exists();

			if(!$isAdmin)
				return Redirect::back()->withErrors('Email or password not match.');
			else
			{
				$remember = (Input::has('remember')) ? true : false;
				$password = Input::get('password');

				$auth = Auth::admin()->attempt(
					[
						'email' => $email,
						'password' => $password
					], $remember
				);

				if($auth){
					// return "Logged in"
					return Redirect::to('users');
				}
	    	else
	    		// return "Failed";
	    		return Redirect::back()->withErrors('Email or password not match.');
			}
		}
	}

	public function logout(){
		Auth::admin()->logout();
		return Redirect::to('/');
	}

	public function listing($section)
	{
		if($section == "users")
    {
    	$list = User::all();
    	return View::make("listing", compact('list','section'));
    }
    else if($section == "prevention")
    {
    	$list = Prevention::all();
    	return View::make("listing", compact('list','section'));
    }
    else if($section == "reports")
    {
    	$list = Report::all();
    	return View::make("listing", compact('list','section'));
    }
    else if($section == "witness")
    {
    	$list = Witness::all();
    	return View::make("listing", compact('list','section'));
    }
	}

	public function view($section, $id){
		if($section == "users")
		{
			$view = User::where('id',$id)->first();
			return View::make("viewing", compact('view','section'));
		}
		else if($section == "prevention")
		{
			$view = Prevention::where('id',$id)->first();
			return View::make("viewing", compact('view','section'));
		}
		else if($section == "reports")
		{
			$view = Report::where('id',$id)->first();
			return View::make("viewing", compact('view','section'));
		}
		else if($section == "witness")
		{
			$view = Witness::where('id',$id)->first();
			return View::make("viewing", compact('view','section'));
		}
	}

	public function edit($section, $id){

		if($section == "prevention")
		{
			$edit = Prevention::find($id);

			if(Input::all() == null)
				return View::make('edit', compact('edit','section','id'));
			else
			{
				$validate = array(
					'imgURL' => 'image|mimes:png,jpg,jpeg',
					'vidURL' => 'mimes:mp4',
					'date' => 'date_format:Y-m-d'
				);

				$validator = Validator::make(Input::all(), $validate);
			
				if($validator->fails())
					return Redirect::to($section.'/edit/'.$id)->withErrors($validator)->withInput();
				else
				{
					if(Input::has('title')){ $edit->title = Input::get('title'); }else{ $edit->title = $edit->title; }
					if(Input::has('subtitle')){ $edit->subtitle = Input::get('subtitle'); }else{ $edit->subtitle = $edit->subtitle; }
					if(Input::has('description')){ $edit->desc = strip_tags(Input::get('description')); }else{ $edit->desc = $edit->desc; }
					if(Input::has('author')){ $edit->author = Input::get('author'); }else{ $edit->author = $edit->author; }
					if(Input::has('date')){ $edit->date = Input::get('date'); }else{ $edit->date = $edit->date; }
					if(Input::has('source')){ $edit->source = Input::get('source'); }else{ $edit->source = $edit->source; }

					if(Input::hasFile('vidURL')){
						$videoOld = basename($edit->vidURL);
						$destinationPath = 'video/prevention/';
						$ip = 'http://192.168.43.138/crime2laravel/public/';

						if($edit->vidURL == null){
							$extension = Input::file('vidURL')->getClientOriginalExtension();
							$filename = $id.'.'.$extension;
							Input::file('vidURL')->move($destinationPath,$filename);
							$edit->vidURL = asset($ip.'video/prevention/'.$filename);
						}else{
							unlink($destinationPath.$videoOld);
							$extension = Input::file('vidURL')->getClientOriginalExtension();
							$filename = $id.'.'.$extension;
							Input::file('vidURL')->move($destinationPath,$filename);
							$edit->vidURL = asset($ip.'video/prevention/'.$filename);
						}
					}

					$imgDestinationPath = 'image/prevention/';
					$ip = 'http://192.168.43.138/crime2laravel/public/';

					if(Input::hasFile('imgURL1')){
						$imgOld1 = basename($edit->imgURL1);
						if($edit->imgURL1 == null){
							$extension1 = Input::file('imgURL1')->getClientOriginalExtension();
							$filename1 = $id.'_1.'.$extension1;
							Input::file('imgURL1')->move($imgDestinationPath,$filename1);
							$edit->imgURL1 = asset($ip.'image/prevention/'.$filename1);
						}else{
							unlink($imgDestinationPath.$imgOld1);
							$extension1 = Input::file('imgURL1')->getClientOriginalExtension();
							$filename1 = $id.'_1.'.$extension1;
							Input::file('imgURL1')->move($imgDestinationPath,$filename1);
							$edit->imgURL1 = asset($ip.'image/prevention/'.$filename1);
						}
					}

					if(Input::hasFile('imgURL2')){
						$imgOld2 = basename($edit->imgURL2);
						if($edit->imgURL2 == null){
							$extension2 = Input::file('imgURL2')->getClientOriginalExtension();
							$filename2 = $id.'_2.'.$extension2;
							Input::file('imgURL2')->move($imgDestinationPath,$filename2);
							$edit->imgURL2 = asset($ip.'image/prevention/'.$filename2);
						}else{
							unlink($imgDestinationPath.$imgOld2);
							$extension2 = Input::file('imgURL2')->getClientOriginalExtension();
							$filename2 = $id.'_2.'.$extension2;
							Input::file('imgURL2')->move($imgDestinationPath,$filename2);
							$edit->imgURL2 = asset($ip.'image/prevention/'.$filename2);
						}
					}

					if(Input::hasFile('imgURL3')){
						$imgOld3 = basename($edit->imgURL3);
						if($edit->imgURL3 == null){
							$extension3 = Input::file('imgURL3')->getClientOriginalExtension();
							$filename3 = $id.'_3.'.$extension3;
							Input::file('imgURL3')->move($imgDestinationPath,$filename3);
							$edit->imgURL3 = asset($ip.'image/prevention/'.$filename3);
						}else{
							unlink($imgDestinationPath.$imgOld3);
							$extension3 = Input::file('imgURL3')->getClientOriginalExtension();
							$filename3 = $id.'_3.'.$extension3;
							Input::file('imgURL3')->move($imgDestinationPath,$filename3);
							$edit->imgURL3 = asset($ip.'image/prevention/'.$filename3);
						}
					}

					if($edit->save())
   					return Redirect::to($section.'/view/'.$id)->with('success','Successfully Updated.');
   				else
   					return Redirect::to($section.'/edit/'.$id)->with('failed','Update failed. Please try again.')->withInput();
   			}//end validator else
			}//end input null else
		}//end prevention section
		else if($section == 'reports')
    {
    	$edit = Report::find($id);

			if(Input::all() == null)
				return View::make('edit', compact('edit','section','id'));
			else
			{
				$validate = array(
					'date' => 'date_format:Y-m-d'
				);

				$validator = Validator::make(Input::all(), $validate);
			
				if($validator->fails())
					return Redirect::to($section.'/edit/'.$id)->withErrors($validator)->withInput();
				else
				{
					if(Input::has('date')){ $edit->reportDT = Input::get('date'); }else{ $edit->reportDT = $edit->reportDT; }
					if(Input::has('route')){ $edit->route = Input::get('route'); }else{ $edit->route = $edit->route; }
					if(Input::has('state')){ $edit->state = Input::get('state'); }else{ $edit->state = $edit->state; }
					if(Input::has('city')){ $edit->city = strip_tags(Input::get('city')); }else{ $edit->city = $edit->city; }
					if(Input::has('postcode')){ $edit->postcode = Input::get('postcode'); }else{ $edit->postcode = $edit->postcode; }
					if(Input::has('latitude')){ $edit->latitude = Input::get('latitude'); }else{ $edit->latitude = $edit->latitude; }
					if(Input::has('longitude')){ $edit->longitude = Input::get('longitude'); }else{ $edit->longitude = $edit->longitude; }
					if(Input::has('description')){ $edit->desc = strip_tags(Input::get('description')); }else{ $edit->desc = $edit->desc; }
					if(Input::has('type')){ $edit->type = Input::get('type'); }else{ $edit->type = $edit->type; }

					$imgDestinationPath = 'image/report/';
					$ip = 'http://192.168.43.138/crime2laravel/public/image/report/';

					if(Input::hasFile('img')){
						$img = Input::file('img');
						$filename = $id.'.jpg';
						$img->move($imgDestinationPath,$filename);
						$image = Image::make(sprintf('image/report/%s',$filename))->resize(300,300)->save();
						$edit->img = asset($ip.$filename);
					}

					if($edit->save())
   					return Redirect::to($section.'/view/'.$id)->with('success','Successfully Updated.');
   				else
   					return Redirect::to($section.'/edit/'.$id)->with('failed','Update failed. Please try again.')->withInput();
   			}//end validator else
			}//end input null else
    }//end reports section
		else if($section == 'witness')
    {
    	$edit = Witness::find($id);

			if(Input::all() == null)
				return View::make('edit', compact('edit','section','id'));
			else
			{
				$validate = array('status' => 'boolean');
				$validator = Validator::make(Input::all(), $validate);
			
				if($validator->fails())
					return Redirect::to($section.'/edit/'.$id)->withErrors($validator)->withInput();
				else
				{
					if(Input::has('status')){ $edit->status = Input::get('status'); }else{ $edit->status = $edit->status; }

					if($edit->save())
   					return Redirect::to($section.'/view/'.$id)->with('success','Successfully Updated.');
   				else
   					return Redirect::to($section.'/edit/'.$id)->with('failed','Update failed. Please try again.')->withInput();
   			}//end validator else
			}//end input null else
    }//end reports section
	}//end edit

	public function add($section)
	{
		if($section == 'prevention')
		{
			if(Input::all() == null)
				return View::make('add', compact('section'));
			else
			{
				$validate = array(
					'title' => 'required',
					'description' => 'required',
					'imgURL' => 'image|mimes:png,jpg,jpeg',
					'vidURL' => 'mimes:mp4',
					'date' => 'required|date_format:Y-m-d',
					'source' => 'required'
				);

				$validator = Validator::make(Input::all(), $validate);

				if($validator->fails())
					return Redirect::to($section.'/add')->withErrors($validator)->withInput();
				else
				{
					$prevention = New Prevention;
					$prevention->title = Input::get('title');
					$prevention->subtitle = Input::get('subtitle');
					$prevention->desc = strip_tags(Input::get('description'));
					$prevention->author = Input::get('author');
					$prevention->date = Input::get('date');
					$prevention->source = Input::get('source');

					if($prevention->save()){
						$id = $prevention->id;
						$ip = 'http://192.168.43.138/crime2laravel/public/';
						$imgDestinationPath = 'image/prevention/';

						if(Input::hasFile('vidURL')){
							$video = Input::file('vidURL');
							$destinationPath = 'video/prevention/';
							$extension = $video->getClientOriginalExtension();
							$filename = $id.'.'.$extension;
							$video->move($destinationPath,$filename);
							$prevention->vidURL = asset($ip.'video/prevention/'.$filename);
						}else
							$prevention->vidURL = null;
						

						if(Input::hasFile('imgURL1')){
							$img1 = Input::file('imgURL1');
							$extension1 = $img1->getClientOriginalExtension();
							$filename1 = $id.'_1.'.$extension1;
							$img1->move($imgDestinationPath,$filename1);
							$image = Image::make(sprintf('image/prevention/%s',$filename1))->resize(300,300)->save();
							$prevention->imgURL1 = asset($ip.'image/prevention/'.$filename1);
						}else
							$prevention->imgURL1 = null;
						

						if(Input::hasFile('imgURL2')){
							$img2 = Input::file('imgURL2');
							$extension2 = $img2->getClientOriginalExtension();
							$filename2 = $id.'_2.'.$extension2;
							$img2->move($imgDestinationPath,$filename2);
							$image = Image::make(sprintf('image/prevention/%s',$filename2))->resize(300,300)->save();
							$prevention->imgURL2 = asset($ip.'image/prevention/'.$filename2);
						}else
							$prevention->imgURL2 = null;
						

						if(Input::hasFile('imgURL3')){
							$img3 = Input::file('imgURL3');
							$extension3 = $img3->getClientOriginalExtension();
							$filename3 = $id.'_3.'.$extension3;
							$img3->move($imgDestinationPath,$filename3);
							$image = Image::make(sprintf('image/prevention/%s',$filename3))->resize(300,300)->save();
							$prevention->imgURL3 = asset($ip.'image/prevention/'.$filename3);
						}else
							$prevention->imgURL3 = null;
						
						$prevention->save();
						return Redirect::to($section.'/add')->with('success','Successfully added.');
					}
					else
						return Redirect::to($section.'/add')->withErrors('Error occurred. Please try again.');
				}//end else validator
			}//end else
		}//end prevention tips
		else if($section == 'reports')
		{
			if(Input::all() == null)
				return View::make('add', compact('section'));
			else
			{
				$validate = array(
					'date' => 'required|date_format:Y-m-d',
					'route' => 'required',
					'state' => 'required',
					'city' => 'required',
					'type' => 'required'
				);

				$validator = Validator::make(Input::all(), $validate);

				if($validator->fails())
					return Redirect::to($section.'/add')->withErrors($validator)->withInput();
				else
				{
					$report = New Report;
					$report->reportDT = Input::get('date');
					$report->route = Input::get('route');
					$report->state = Input::get('state');
					$report->city = Input::get('city');
					$report->postcode = Input::get('postcode');
					$report->latitude = Input::get('lat');
					$report->longitude = Input::get('lng');
					$report->desc = strip_tags(Input::get('description'));
					$report->type = Input::get('type');

					if($report->save()){
						$id = $report->id;
						$ip = 'http://192.168.43.138/crime2laravel/public/image/report/';
						$imgDestinationPath = 'image/report/';

						if(Input::hasFile('img')){
							$img = Input::file('img');
							$filename = $id.'.jpg';
							$img->move($imgDestinationPath,$filename);
							$image = Image::make(sprintf('image/report/%s',$filename))->resize(300,300)->save();
							$report->img = asset($ip.$filename);
						}else
							$report->img = null;
						
						$report->save();
						return Redirect::to($section.'/add')->with('success','Successfully added.');
					}
					else
						return Redirect::to($section.'/add')->withErrors('Error occurred. Please try again.');
				}//end else validator
			}//end else input null
		}//end reports section
	}//end add function
    

	public function delete($section,$id)
	{
		if($section == 'prevention')
		{
			$tips = Prevention::find($id);

			if(!$tips)
    		return Redirect::to($section)->withErrors('[Error] Prevention not found.');
    	else{
    		if($tips->vidURL == NULL && $tips->imgURL1 == NULL && $tips->imgURL2 == NULL && $tips->imgURL3 == NULL)
    			$tips->delete();
    		else
    		{
    			if($tips->vidURL != NULL)
    				unlink(public_path().'/video/prevention/'.basename($tips->vidURL));

    			if($tips->imgURL1 != NULL)
    				unlink(public_path().'/image/prevention/'.basename($tips->imgURL1));

    			if($tips->imgURL2 != NULL)
    				unlink(public_path().'/image/prevention/'.basename($tips->imgURL2));

    			if($tips->imgURL3 != NULL)
    				unlink(public_path().'/image/prevention/'.basename($tips->imgURL3));

	    		$tips->delete();
    		}
    		return Redirect::to($section)->with('success','Successfully deleted.');
    	}
		}
    else if($section == 'users')
    {
    	$user = User::find($id);

    	if(!$user)
    		return Redirect::to($section)->withErrors('[Error] User not found.');
    	else
    	{
    		$image = basename($user->img);
    		if($image == "default_user_img.png")
    			$user->delete();
    		else{
    			unlink(public_path().'/user_img/'.$image);
    			$user->delete();
    		}
    		return Redirect::to($section)->with('success','Successfully deleted.');
    	}
    }
    else if($section == 'reports')
    {
    	$report = Report::find($id);

    	if(!$report)
    		return Redirect::to($section)->withErrors('[Error] Report not found.');
    	else
    	{
    		if($report->img == NULL)
    			$report->delete();
    		else{
    			unlink(public_path().'/image/report/'.basename($report->img));
    			$report->delete();
    		}
    		return Redirect::to($section)->with('success','Successfully deleted.');
    	}
    }
    else if($section == 'witness')
    {
    	$witness = Witness::find($id);

    	if(!$witness)
    		return Redirect::to($section)->withErrors('[Error] Witness not found.');
    	else
    	{
    		if($witness->img == NULL)
    			$witness->delete();
    		else{
    			unlink(public_path().'/image/witness/'.basename($witness->img));
    			$witness->delete();
    		}
    		return Redirect::to($section)->with('success','Successfully deleted.');
    	}
    }
	}
}