<?php

namespace App\Orchid\Screens;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Quill;
use Exception;

class MessageScreen extends Screen
{
    /**
     * The base view that will be rendered.
     */
    public function screenBaseView(): string
    {
        return 'base';
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $messages = Message::all();
        return [
            'messages' => $messages
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'MessageScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('отправить')->method('create'),
        ];
    }

    public function create(Request $request)
    {
        try {
            $this->authorize('create',Message::class);
            $message = new Message();
            $message->message = $request->input('message');
            $message->user_id = Auth::id();
            $message->save() ? Toast::info('Сообщение отпарвлено') : Toast::info('Ошибка');

        } catch (Exception $e) {
            return back()->with(['error' => 'Вы не авторизованы']);

        }
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public
    function layout(): iterable
    {
        return [
            Layout::view('welcome'),
            Layout::rows([
                Quill::make('message')
                    ->title('message')
                    ->popover('Quill is a free, open source WYSIWYG editor built for the modern web.'),

            ]),

        ];
    }
}
