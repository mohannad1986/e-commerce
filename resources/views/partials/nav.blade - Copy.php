<header>
    <div class="top-nav container">
      <div class="top-nav-left">

          <div class="logo"><a href="/">Ecommerce000</a></div>
          {{-- هي الدالة تحقق من المسار  --}}
          {{-- المسار هو اخر اسم بعد الايتضافة 
          حتى لو كان في باراميتر بعد اسم المسار مابياخد فيه --}}
          {{-- استورد في حا ماكنت بهي الصفحات  --}}
          @if (! (request()->is('checkout') || request()->is('guestCheckout')))
          {{-- استورد الميتنو تبع قائمة الفويجر --}}
          {{-- تبع انشاؤ حساب تسجيل جخول  --}}
          {{-- {{ menu('main', 'partials.menus.main') }} --}}
          
          @endif
      </div>
      <div class="top-nav-right">
          @if (! (request()->is('checkout') || request()->is('guestCheckout')))
          {{-- @include('partials.menus.main-right') --}}
          @endif
      </div>
    </div> <!-- end top-nav -->
</header>
