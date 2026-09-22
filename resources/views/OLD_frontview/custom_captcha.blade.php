<!-- resources/views/custom_captcha.blade.php -->

<div class="captcha-image">
    <img src="{{ captcha_src('default') }}" alt="Captcha" onclick="this.src='/captcha/default?'+Math.random()"
        style="cursor: pointer">
</div>
