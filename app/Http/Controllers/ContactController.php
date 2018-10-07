<?php

namespace Corp\Http\Controllers;

use Corp\Mail\Feedback;
use Corp\Repositories\MenuRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends SiteController
{
    public function __construct(MenuRepository $m_rep)
    {
        parent::__construct($m_rep);

        $this->template = 'contacts';
        $this->bar = 'left';
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ]);

            $data = $request->all();
            try {
                Mail::to('saintdronchik@gmail.com', 'Андрей')
                    ->send(new Feedback($data));
                return back()->with(['status' => trans('custom.email_is_send')]);
            } catch (\Exception $exception) {
                return redirect()->route('contacts')->with(['error' => 'Не удалось отправить письмо']);
            }

            /*
            try {
                $result = Mail::send(config('settings.theme') . '.email', ['data' => $data], function ($message) use ($data) {
                    $message->from($data['email'], $data['name']);
                    $message->to('saintdronchik@gmail.com', 'Андрей')->subject('Corporate');
                });
            } catch (\Exception $exception) {
                return redirect()->route('contacts')->with(['error' => 'Произошла ошибка']);
            }*/
        }


        $this->title = 'Контакты';
        $this->keywords = 'Контакты_ключи';
        $this->meta_desc = 'Контакты_описание';

        $content_view = view(config('settings.theme') . '.contacts_content')
            ->render();
        $this->vars = array_add($this->vars, 'content_view', $content_view);

        $this->contentLeftBar = view(config('settings.theme') . '.contactsBar')
            ->render();

        return $this->renderOutput();
    }
}
