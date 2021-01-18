<?php

namespace App\Http\Controllers;

use App\Email;
use App\Issuelist;
use App\Http\Requests\EmailFormRequest;
use Illuminate\Http\Request;
use function redirect;
use function view;

class IssuelistEmailsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Issuelist $issuelist)
    {
        $email = new Email();
        $email->issueList()->associate($issuelist);

        return view('issuelists.emails.editform')
            ->with('email', $email);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmailFormRequest $request
     * @param Issuelist        $issuelist
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function store(EmailFormRequest $request, Issuelist $issuelist)
    {
        $email = new Email();
        $email->issueList()->associate($issuelist);
        $email->default_recipient = $request->input('default_recipient');
        $email->subject           = $request->input('subject');
        $email->body              = $request->input('body');
        $email->save();

        foreach ($request->file('attachments', []) as $attachment) {
            $email->addMedia($attachment)
                ->toMediaCollection('attachments');
        }

        $request->session()->flash('successmessage', __('Email added'));

        return redirect()->route('issuelists.show', [$issuelist]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Issuelist $issuelist
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Issuelist $issuelist, Email $email)
    {
        return view('issuelists.emails.editform')
            ->with('email', $email);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmailFormRequest $request
     * @param Issuelist        $issuelist
     * @param Email            $email
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function update(EmailFormRequest $request, Issuelist $issuelist, Email $email)
    {
        $email->issueList()->associate($issuelist);
        $email->default_recipient = $request->input('default_recipient');
        $email->subject           = $request->input('subject');
        $email->body              = $request->input('body');
        $email->save();

        $email->media()->whereNotIn('id', $request->input('keepattachments', []))->delete();

        foreach ($request->file('attachments', []) as $attachment) {
            $email->addMedia($attachment)
                ->toMediaCollection('attachments');
        }

        $request->session()->flash('successmessage', __('Email updated'));
        return redirect()->route('issuelists.show', [$issuelist]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request   $request
     * @param Issuelist $issuelist
     * @param Email     $email
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Issuelist $issuelist, Email $email)
    {
        $email->delete();

        $request->session()->flash('successmessage', __('Email deleted'));
        return redirect()->route('issuelists.show', [$issuelist]);
    }
}
