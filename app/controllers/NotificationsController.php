<?php

class NotificationsController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Request::ajax())
        {
            if (Input::get('rOb') == 'agent')
            {
                if (Input::get('rId'))
                {
                    $agent = Agent::find(Input::get('rId'));
                    if ($agent)
                    {
                        $noexist = $agent->checkRank(Input::get('lrank'), Input::get('hrank'),$agent->id );
                        // TRUE if not found, FALSE if found
                        if ($noexist)
                        {
                            $agent->lRank = Input::get('lrank');
                            $agent->hRank = Input::get('hrank');
                            $agent->save();

                            $form_data = array();
                            $form_data['department'] = Input::get('lrank');
                            $form_data['city'] = Input::get('hrank');
                            $form_data['text'] = Input::get('text');
                            $form_data['rId'] = Input::get('rId');
                            $form_data['isActv'] = TRUE;
                            $form_data['date'] = Input::get('date'); //date('d-m-Y [H:i]');
                            $form_data['rOb'] = Input::get('rOb');
                            $form_data['desc'] = Auth::user()->id;
                            $notification = new Notification($form_data);
                            $notification->save();
                        } else
                        {
                            $response = array(
                                'status' => 'error',
                                'msg' => 'Oups! Rank déjà utilisé',
                            );
                            return Response::json($response);
                        }
                    }
                }
            } else
            {
                $form_data = array();
                $form_data['text'] = Input::get('text');
                $form_data['type'] = Input::get('type');
                $form_data['rId'] = Input::get('rId');
                $form_data['isActv'] = TRUE;
                $form_data['date'] = Input::get('date'); //date('d-m-Y [H:i]');
                $form_data['department'] = Input::get('department');
                $form_data['city'] = Input::get('city');
                $form_data['cSection'] = Input::get('section');
                $form_data['abbatoire'] = Input::get('abbatoire');
                $form_data['so'] = Input::get('so');
                $form_data['rOb'] = 'animal';
                $form_data['desc'] = Auth::user()->id;
                $notification = new Notification($form_data);
                $notification->save();
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
