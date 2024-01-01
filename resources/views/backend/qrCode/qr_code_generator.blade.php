<!-- qr_code_generator.blade.php -->

@extends('backend.layouts.app') <!-- If you have a master layout, extend it -->

@section('content')
    <div>
        <!-- Display any previous QR codes generated by the user -->


        <!-- QR code generator form -->

        <table class="table">
            <tr>
                <th>Send QR Code</th>
            </tr>
            <tr>
                <td>

                    <form action="{{ route('generate_qr_code.post') }}" method="POST">
                        @csrf
                        <!-- Add any necessary form inputs here -->
                        @foreach($user as $item)
                            <!-- Example: If you want the user to input a name -->
                                <input type="hidden" name="name" id="name" value="{{$item->name}}">
                                <input type="hidden" name="email" id="email" value="{{$item->email}}">
                                <input type="hidden" name="user_id" id="email" value="{{$item->id}}">
                                @foreach($offer as $offers)
                                    <input type="hidden" name="offer_title" id="name" value="{{$offers->offer_title}}">
                                    <input type="hidden" name="offer_id" id="name" value="{{$offers->id}}">
                                    <input type="hidden" name="offer_amount" id="email" value="{{$offers->offer_amount}}">
                                @endforeach
                                <button class="btn btn-success" type="submit">Get Cash Bck</button>
                            @endforeach
                        </form>
                </td>
            </tr>
        </table>
    </div>
@endsection