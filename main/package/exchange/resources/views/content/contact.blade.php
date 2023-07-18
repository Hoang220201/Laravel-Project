@extends('Exchange::layouts.main')
@section('title','contact')

<link href="{{ asset('css/contact.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@section('scripts')
  <script  src="{{asset('contact.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="contactform">
            <div class="form" id="contactform">
                <h2>Contact Us Now</h2>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Your name"  required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Your email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button id="submit" disabled>Submit</button>
            </div>
          
            <div id="thankyou" class="thankyou">
                <div class="mail-icon" hidden><i class="fa-solid fa-envelope-circle-check icon"></i></div>
            </div>

            <div class="map">
                <h2>See our office</h2>
                <p><b>Address:</b> 20 Bridge St, Sydney NSW 2000, Australia</p>
                <p><b>Email:</b> contact@cxc.au</p>
                <p><b>Tel:</b> <span>+61.5073.2496</span></p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1171.319114707609!2d151.2099381648531!3d-33.86412911256613!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae422049e087%3A0x167b18e512450d6e!2s20%20Bridge%20St%2C%20Sydney%20NSW%202000%2C%20%C3%9Ac!5e0!3m2!1svi!2s!4v1684850415495!5m2!1svi!2s" class="ggmap" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <div class="extra">
    </div>
@endsection