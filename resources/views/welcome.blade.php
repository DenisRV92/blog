<style>
    .message {
        border: 1px solid white;
        background-color: white;
        height: 50px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .error {
        color: red;
        text-align: center;
        font-size: 20px;
    }
</style>

<div>
    @foreach($messages as $message)
        <div class="row message">
            {!! $message->message !!}
        </div>
    @endforeach
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
</div>

