<?php
header('Access-Control-Allow-Origin: *');
class UserController extends BaseController {

	public function login(){

		$userdata = array(
			'email' 	=> Request::get('email'),
			'password' 		=> Request::get('password')
		);

		$isAuth = Auth::user()->attempt($userdata);

		if($isAuth) {

			$id = Auth::user()->id();
			return Response::json(array('success' => true,'code' => '200','message' => 'User found.','data' => $id));

		} else {
			return Response::json(array('success' => false,'code' => '404','message' => 'User not found / Incorrect password.'));
		} 
	}

	public function forgotpw()
	{
		$rules = array(
  		'email' => 'required|email',
  		'password' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()){
			$error = "[Error] Validation Fail";
			return Response::json(array('success' => false,'message' => $validator->getMessageBag()));
		} else {

			$email = Input::get('email');
			$password = Input::get('password');

			$user = User::where('email',$email)->first();

			if(!$user){
				return Response::json(array('success' => false,'message' => 'User not found. Please try again','status' => 200));
			} else {
				$user->password = Hash::make($password);
				$user->save();

				$data = array(
					'id' => $user->id,
					'name' => $user->name,
					'email' => $user->email
				);
			}
		}
		return Response::json(array('success' => true,'message'=> 'Successfully changed password','data' => $data,'status' => 200));
	}

	public function signup()
	{
		$rules = array(
			'name' => 'required',
  		'email' => 'required|email|unique:users,email',
  		'password' => 'required',
  		'ic' => 'required|unique:users,ic',
  		'gender' => 'required',
  		'hpnum' => 'required',
  		'address' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			$error = "[Error] Validation Fail";
			return Response::json(array('success' => false,'message' => $validator->getMessageBag())); 
		
		} else {

			$name = Input::get('name');
			$password = Input::get('password');
			$emertext = ". I am in danger. Please help me.";
		
			$user = New User;
			$user->name = $name;
			$user->email = Input::get('email');
			$user->password = Hash::make($password);
			$user->ic = Input::get('ic');
			$user->gender = Input::get('gender');
			$user->hpnum = Input::get('hpnum');
			$user->address = Input::get('address');
			$user->emerText = 'My name is '.$name.$emertext;
			$user->img = asset('user_img/default_user_img.png');
			$user->save();

			$data = array(
				'id' => $user->id,
				'name' => $user->name,
				'email' => $user->email
			); 
		}
		return Response::json(array('success' => true,'message'=> 'Successfully signed up','data' => $data,'status' => 200));
	}

	public function viewprofile($id)
	{
        $user = User::find($id);
        $profile = User::where('id',$id)->first();

        if($profile)
            return Response::json(array('success' => true,'data' => $profile,'status' => 200));
        else
            return Response::json(array('success' => false,'message' => 'User not found. Please try again','status' => 200));
	}

	public function editprofile($id)
	{
		$user = User::find($id);

		if(!$user){
			return Response::json(array('success' => false,'message' => 'User not found. Please try again','status' => 200));
		} else {

			if(empty(Input::all())){
				return Response::json(array('code' => '304', 'message' => 'Parameters are empty.'));
			} else {

				$rules = array(
					'email'	=> 'email|unique:users,email',
					'ic' => 'unique:users,ic'
				);

				$validator = Validator::make(Input::all(), $rules);

				if($validator->passes()){

					if(Input::has('name')){ $user->name = Input::get('name'); }else{ $user->name = $user->name; }
					if(Input::has('email')){ $user->email = Input::get('email'); }else{ $user->email = $user->email; }
					if(Input::has('ic')){ $user->ic = Input::get('ic'); }else{ $user->ic = $user->ic; }
					if(Input::has('hpnum')){ $user->hpnum = Input::get('hpnum'); }else{ $user->hpnum = $user->hpnum; }
					if(Input::has('address')){ $user->address = Input::get('address'); }else{ $user->address = $user->address; }
					if(Input::has('img')){ $user->img = Input::get('img'); }else{ $user->img = $user->img; }

					// if(Input::has('img')){
					// 	$image = Input::get('img');
					// 	$user->img = asset('http://192.168.43.138/crime2laravel/public/user_img/'.$image);
					// }

					if($user->save())
						return Response::json(array('success' => true,'message'=> 'Successfully updated.','data' => $user,'status' => 200));
					else
						return Response::json(array('success' => false,'message' => 'Updated failed.','status' => 200));
					
				} else { 
					$error = "[Error] Validation Fail";
					return Response::json(array('success' => false,'message' => $validator->getMessageBag()));
				}
			}
		}
	}

	public function addcontact($id)
	{
		$user = User::find($id);

		if(!$user)
			return Response::json(array('success' => false,'message' => 'User not found. Please try again','status' => 200));
		else {

			$number = DB::table('emergency')
							->where('emergency.userID', $id)
							->count();

			if($number == 5)
				return Response::json(array('success' => false,'message' => 'You have reached the maximum number of emergency contacts.'));
			else {

				$rules = array(
		    	'name' => 'required',
					'hpnum' => 'required'
		    );

		    $validator = Validator::make(Input::all(), $rules);

		    if($validator->passes()){

					$contact = new Contact;
					$contact->userID = $id;
					$contact->name = Input::get('name');
					$contact->hpnum = Input::get('hpnum');
					$contact->save();

					$data = array(
						'id' => $contact->id,
						'name' => $contact->name,
						'hpnum' => $contact->hpnum,
						'userID' => $contact->userID
					);

					return Response::json(array('success' => true,'message'=> 'Successfully added.','data' => $data,'status' => 200));

		    } else {
		    	$error = "[Error] Validation Fail";
					return Response::json(array('success' => false,'message' => $validator->getMessageBag()));
		    }
			}
		}
	}

	public function viewallcontacts($id)
	{
		$user = User::find($id);

		if(!$user)
			return Response::json(array('success' => false,'message' => 'User not found. Please try again.','status' => 200));
		else {

			$contacts = DB::table('emergency')
								->where('emergency.userID',$id)
								->get();

			return Response::json(array('success' => true,'message'=> 'Retrieved successfully.','data' => $contacts,'status' => 200));
		}
	}

	public function delcontact($id)
	{
		$contact = Contact::find($id);

		if(!$contact)
			return Response::json(array('success' => false,'message' => 'Contact not found. Please try again.','status' => 200));
		else {

			$contact->delete();
			return Response::json(array('success' => true,'message'=> 'Deleted successfully.','status' => 200));
		}
	}

	public function editcontact($id)
	{
		$contact = Contact::find($id);

		if(!$contact)
			return Response::json(array('success' => false,'message' => 'Contact not found. Please try again.','status' => 200));
		else {

			if(empty(Input::all()))
				return Response::json(array('success' => false,'message' => 'Parameters are empty.','status' => 200));
			else {

	    	if(Input::has('name')){ $contact->name = Input::get('name'); }else{ $contact->name = $contact->name; }
	    	if(Input::has('hpnum')){ $contact->hpnum = Input::get('hpnum'); }else{ $contact->hpnum = $contact->hpnum; }

	    	if($contact->save())
	    	{
	    		$data = DB::table('emergency')->where('emergency.id',$id)->first();
	    		return Response::json(array('success' => true,'message' => 'Updated successfully.','data' => $data,'status' => 200));
	    	}
	    	else
	    		return Response::json(array('success' => false,'message' => 'Updated failed.','status' => 200));
			}
		}
	}

	public function viewalltips()
	{
		$tips = Prevention::all();
		return Response::json(array('success' => true,'message'=> 'Retrieved successfully.','data' => $tips,'status' => 200));
	}

	public function viewtip($id)
	{
		$tip = Prevention::find($id);
		$images = array();
		$videos = array();

		if($tip->imgURL1 != null)
			array_push($images, $tip->imgURL1);
		if($tip->imgURL2 != null)
			array_push($images, $tip->imgURL2);
		if($tip->imgURL3 != null)
			array_push($images, $tip->imgURL3);
		if($tip->vidURL != null)
			array_push($videos, $tip->vidURL);

		$tipInfo = Prevention::where('id',$id)->select('id','title','subtitle','desc','date','author','source')->first();
		$data = array('tip_data' => $tipInfo,'tip_images' => $images,'tip_video' => $videos);
		
		if(!$tip)
			return Response::json(array('success' => false,'message' => 'Prevention tip not found. Please try again.','status' => 200));
		else
			return Response::json(array('success' => true,'message'=> 'Retrieved successfully.','data' => $data,'status' => 200));
	}

	public function addwitness($id)
	{
		$user = User::find($id);

		if(!$user)
			return Response::json(array('success' => false,'message' => 'User not found. Please try again','status' => 200));
		else {

			$rules = array(
	    	'dateTime' => 'required',
				'state' => 'required',
				'city' => 'required',
				'type' => 'required'
	    );

	    $validator = Validator::make(Input::all(), $rules);

	    if($validator->passes()){

				$witness = new Witness;
				$witness->userID = $id;
				$witness->incidentDT = Input::get('dateTime');
				$witness->state = Input::get('state');
				$witness->city = Input::get('city');
				$witness->postcode = Input::get('postcode');
				$witness->latitude = Input::get('latitude');
				$witness->longitude = Input::get('longitude');
				$witness->desc = Input::get('desc');
				$witness->type = Input::get('type');
				$witness->img = Input::get('img');
				$witness->save();

				$data = array(
					'id' => $witness->id,
					'userID' => $witness->userID,
					'incidentDT' => $witness->incidentDT,
					'state' => $witness->state,
					'city' => $witness->city,
					'postcode' => $witness->postcode,
					'desc' => $witness->desc,
					'type' => $witness->type,
					'img' => $witness->img
				);

				return Response::json(array('success' => true,'message'=> 'Successfully added.','data' => $data,'status' => 200));

	    } else {
	    	$error = "[Error] Validation Fail";
				return Response::json(array('success' => false,'message' => $validator->getMessageBag()));
	    }
		}
	}

	public function viewallreminder($id)
	{
		$user = User::find($id);

		if(!$user)
			return Response::json(array('success' => false,'message' => 'User not found. Please try again.','status' => 200));
		else {
			$reminders = DB::table('reminder')
									->where('reminder.userID',$id)
									->get();

			$allreminder = array();

			for($i=0; $i<count($reminders); $i++){

				$reminderDT = $reminders[$i]->reminderDT;
				$reminderID = $reminders[$i]->id;
				$now = Carbon::now();

				if($reminderDT<$now){
					$reminder = Reminder::find($reminderID);
					$reminder->delete();
				} else if($reminderDT>$now){
					$reminder = Reminder::where('id',$reminderID)->first();
					array_push($allreminder, $reminder);
				}
			}

			return Response::json(array('success' => true,'message'=> 'Retrieved successfully.','data' => $allreminder,'status' => 200));
		}
	}

	public function delreminder($id)
	{
		$reminder = Reminder::find($id);

		if(!$reminder)
			return Response::json(array('success' => false,'message' => 'Reminder not found. Please try again.','status' => 200));
		else {
			$reminder->delete();
			return Response::json(array('success' => true,'message'=> 'Deleted successfully.','status' => 200));
		}
	}

	public function addreminder($id)
	{
		$user = User::find($id);

		if(!$user)
			return Response::json(array('success' => false,'message' => 'User not found. Please try again','status' => 200));
		else {

			$rules = array(
	    	'reminderDT' => 'required',
				'receiver' => 'required',
				'message' => 'required'
	    );

	    $validator = Validator::make(Input::all(), $rules);

	    if($validator->passes()){

				$reminder = new Reminder;
				$reminder->userID = $id;
				$reminder->reminderDT = Input::get('reminderDT');
				$reminder->receiver = Input::get('receiver');
				$reminder->message = Input::get('message');
				$reminder->now = Input::get('now');
				$reminder->save();

				$data = array(
					'id' => $reminder->id,
					'userID' => $reminder->userID,
					'reminderDT' => $reminder->reminderDT,
					'message' => $reminder->message,
					'receiver' => $reminder->receiver
				);

				return Response::json(array('success' => true,'message'=> 'Successfully added.','status' => 200,'data' => $data));

	    } else {
	    	$error = "[Error] Validation Fail";
				return Response::json(array('success' => false,'message' => $validator->getMessageBag()));
	    }
		}
	}

	public function editreminder($id)
	{
		$reminder = Reminder::find($id);

		if(!$reminder)
			return Response::json(array('success' => false,'message' => 'Reminder not found. Please try again.','status' => 200));
		else {

			if(empty(Input::all()))
				return Response::json(array('success' => false,'message' => 'Parameters are empty.','status' => 200));
			else{

	    	if(Input::has('reminderDT')){ $reminder->reminderDT = Input::get('reminderDT'); }else{ $reminder->reminderDT = $reminder->reminderDT; }
	    	if(Input::has('message')){ $reminder->message = Input::get('message'); }else{ $reminder->message = $reminder->message; }

	    	if($reminder->save())
	    	{
	    		$data = DB::table('reminder')->where('reminder.id',$id)->first();
	    		return Response::json(array('success' => true,'message' => 'Updated successfully.','data' => $data,'status' => 200));
	    	}
	    	else
	    		return Response::json(array('success' => false,'message' => 'Updated failed.','status' => 200));
			}
		}
	}

	public function viewallreports()
	{
		$report = DB::table('report')
							->select('report.route as route','report.reportDT as date','report.state as state','report.city as city','report.postcode as postcode','report.desc as desc','report.type as type','report.latitude as lat','report.longitude as long',DB::raw("'Authority' AS category"))
							->get();
		$invalid = DB::table('witness')
							->where('witness.status',0)
							->select('witness.route as route','witness.incidentDT as date','witness.state as state','witness.city as city','witness.postcode as postcode','witness.desc as desc','witness.type as type','witness.latitude as lat', 'witness.longitude as long',DB::raw("'Invalid' AS category"))
							->get();
		$valid = DB::table('witness')
							->where('witness.status',1)
							->select('witness.route as route','witness.incidentDT as date','witness.state as state','witness.city as city','witness.postcode as postcode','witness.desc as desc','witness.type as type','witness.latitude as lat', 'witness.longitude as long',DB::raw("'Valid' AS category"))
							->get();

		$full = array();
		foreach($report as $r){
			$dataA = array(
				'route' => $r->route,
				'date' => $r->date,
				'state' => $r->state,
				'city' => $r->city,
				'postcode' => $r->postcode,
				'desc' => $r->desc,
				'type' => $r->type,
				'lat' => $r->lat,
				'long' => $r->long,
				'category' => $r->category
			);
			array_push($full,$dataA);
		}

		foreach($valid as $v){
			$dataC = array(
				'route' => $v->route,
				'date' => $v->date,
				'state' => $v->state,
				'city' => $v->city,
				'postcode' => $v->postcode,
				'desc' => $v->desc,
				'type' => $v->type,
				'lat' => $v->lat,
				'long' => $v->long,
				'category' => $v->category
			);
			array_push($full,$dataC);
		}

		foreach($invalid as $i){
			$dataB = array(
				'route' => $i->route,
				'date' => $i->date,
				'state' => $i->state,
				'city' => $i->city,
				'postcode' => $i->postcode,
				'desc' => $i->desc,
				'type' => $i->type,
				'lat' => $i->lat,
				'long' => $i->long,
				'category' => $i->category
			);
			array_push($full,$dataB);
		}
		
		return Response::json(array('data' => $full));
	}
	
}
