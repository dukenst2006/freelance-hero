@extends('layouts.app')

@section('content')
<div class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-message">
                    <h1>Freelance Hero</h1>
                    <h3>Companion App for the Self-Employed</h3>
                    <hr class="intro-divider">
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>

<a name="about"></a>
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-6">
                <hr class="section-heading-spacer">
                <div class="clearfix"></div>
                <h2 class="section-heading">About Freelance Hero</h2>
                <p class="lead">Freelance Hero is an app that helps freelancers and contractors manage ongoing projects, log individual work sessions, and generate invoices. Create an account and get started today!</p>
            </div>
            <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                <img class="img-responsive" src="/books.jpg" alt="">
            </div>
        </div>
    </div>
</div>

<a name="contact"></a>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-6">
                <hr class="section-heading-spacer">
                <div class="clearfix"></div>
                <h2 class="section-heading">Contact Us</h2>
                <p class="lead">Have questions or comments? Drop us a line!</p>
            </div>
            <div class="col-lg-6 col-sm-6">
                <form action="/contact" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="fullName">Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments</label>
                        <textarea class="form-control" rows="3" id="comments" name="comments"></textarea>  
                    </div>
                    <div class="form-group">
                        {!! app('captcha')->display(); !!}
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-inline">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="footer-menu-divider">&sdot;</li>
                    <li>
                        <a href="/#about">About</a>
                    </li>
                    <li class="footer-menu-divider">&sdot;</li>
                    <li>
                        <a href="/#contact">Contact</a>
                    </li>
                </ul>
                <p class="copyright text-muted small">Copyright &copy; Freelance Hero 2016. All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>
@endsection
