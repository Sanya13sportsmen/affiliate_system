<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLink;
use App\Models\Click;
use App\Models\Link;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLink  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLink $request)
    {
        $user = Auth::user();

        $link = new Link();
        $link->fill($request->all());
        $link->user_id = $user->id;
        $link->code = $this->generateCode();
        $link->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request, $code)
    {
        $link = Link::where('code', $code)->first();

        if (!$link) {
            return redirect()->back();
        }

        $visitor = new Visitor();
        $visitor->link_id = $link->id;
        $visitor->ip = $request->ip();
        $visitor->user_agent = $request->header('User-Agent');
        $visitor->save();

        $url = $link->url;

        $query = parse_url($url, PHP_URL_QUERY);

        if ($query) {
            $url .= '&code=' . $code;
        } else {
            $url .= '?code=' . $code;
        }

        return redirect()->away($url);
    }

    /**
     * @return bool|string
     */
    private function generateCode()
    {
        do {
            $code = substr(sha1(microtime()), 0, 12);
        } while (Link::where('code', $code)->first());

        return $code;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function click(Request $request)
    {
        $link = Link::where('code', $request->input('code'))->first();

        if ($link) {
            $link->clicks()->save(new Click());

            return response()->json([
               'message' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ], 400);
        }
    }
}
