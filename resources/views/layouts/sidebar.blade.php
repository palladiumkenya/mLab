
  <div class="side-content-wrap">
            <div class="sidebar-left open" data-perfect-scrollbar data-suppress-scroll-x="true">
                <ul class="navigation-left">
                <li class="nav-item {{ request()->is('dashboard/*') ? 'active' : '' }}" data-item="dashboard">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Bar-Chart"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('uikits/*') ? 'active' : '' }}" data-item="uikits">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Library"></i>
                            <span class="nav-text">UI kits</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('extrakits/*') ? 'active' : '' }}" data-item="extrakits">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Suitcase"></i>
                            <span class="nav-text">Extra kits</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('apps/*') ? 'active' : '' }}" data-item="apps">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Computer-Secure"></i>
                            <span class="nav-text">Apps</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('forms/*') ? 'active' : '' }}" data-item="forms">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-File-Clipboard-File--Text"></i>
                            <span class="nav-text">Forms</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('datatables/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('basic-tables')}}">
                            <i class="nav-icon i-File-Horizontal-Text"></i>
                            <span class="nav-text">Datatables</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('sessions/*') ? 'active' : '' }}" data-item="sessions">
                        <a class="nav-item-hold" href="/test.html">
                            <i class="nav-icon i-Administrator"></i>
                            <span class="nav-text">Sessions</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('others/*') ? 'active' : '' }}" data-item="others">
                        <a class="nav-item-hold" href="">
                            <i class="nav-icon i-Double-Tap"></i>
                            <span class="nav-text">Others</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="http://demos.ui-lib.com/gull-html-doc/" target="_blank">
                            <i class="nav-icon i-Safe-Box1"></i>
                            <span class="nav-text">Doc</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                </ul>
            </div>

            <div class="sidebar-left-secondary" data-perfect-scrollbar data-suppress-scroll-x="true">
                <!-- Submenu Dashboards -->
                <ul class="childNav" data-parent="dashboard">
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName()=='dashboard_version_1' ? 'open' : '' }}" href="{{route('dashboard_version_1')}}">
                            <i class="nav-icon i-Clock-3"></i>
                            <span class="item-name">Version 1</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('dashboard_version_2')}}" class="{{ Route::currentRouteName()=='dashboard_version_2' ? 'open' : '' }}">
                            <i class="nav-icon i-Clock-4"></i>
                            <span class="item-name">Version 2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='dashboard_version_3' ? 'open' : '' }}" href="{{route('dashboard_version_3')}}" >
                            <i class="nav-icon i-Over-Time"></i>
                            <span class="item-name">Version 3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='dashboard_version_4' ? 'open' : '' }}" href="{{route('dashboard_version_4')}}">
                            <i class="nav-icon i-Clock"></i>
                            <span class="item-name">Version 4</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="forms">
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='forms-basic' ? 'open' : '' }}" href="{{route('forms-basic')}}">
                            <i class="nav-icon i-File-Clipboard-Text--Image"></i>
                            <span class="item-name">Basic Elements</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='form-layouts' ? 'open' : '' }}" href="{{route('form-layouts')}}">
                            <i class="nav-icon i-Split-Vertical"></i>
                            <span class="item-name">Form Layouts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='form-input-group' ? 'open' : '' }}" href="{{route('form-input-group')}}">
                            <i class="nav-icon i-Receipt-4"></i>
                            <span class="item-name">Input Groups</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='form-validation' ? 'open' : '' }}" href="{{route('form-validation')}}">
                            <i class="nav-icon i-Close-Window"></i>
                            <span class="item-name">Form Validation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='smartWizard' ? 'open' : '' }}" href="{{route('smartWizard')}}">
                            <i class="nav-icon i-Width-Window"></i>
                            <span class="item-name">Smart Wizard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='tagInput' ? 'open' : '' }}" href="{{route('tagInput')}}">
                            <i class="nav-icon i-Tag-2"></i>
                            <span class="item-name">Tag Input</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='form-editor' ? 'open' : '' }}" href="{{route('form-editor')}}">
                            <i class="nav-icon i-Pen-2"></i>
                            <span class="item-name">Rich Editor</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="apps">
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='invoice' ? 'open' : '' }}" href="{{route('invoice')}}">
                            <i class="nav-icon i-Add-File"></i>
                            <span class="item-name">Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='inbox' ? 'open' : '' }}" href="{{route('inbox')}}">
                            <i class="nav-icon i-Email"></i>
                            <span class="item-name">Inbox</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='chat' ? 'open' : '' }}" href="{{route('chat')}}">
                            <i class="nav-icon i-Speach-Bubble-3"></i>
                            <span class="item-name">Chat</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="extrakits">
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='imageCroper' ? 'open' : '' }}" href="{{route('imageCroper')}}">
                            <i class="nav-icon i-Crop-2"></i>
                            <span class="item-name">Image Cropper</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='loader' ? 'open' : '' }}" href="{{route('loader')}}">
                            <i class="nav-icon i-Loading-3"></i>
                            <span class="item-name">Loaders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='laddaButton' ? 'open' : '' }}" href="{{route('laddaButton')}}">
                            <i class="nav-icon i-Loading-2"></i>
                            <span class="item-name">Ladda Buttons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='toastr' ? 'open' : '' }}" href="{{route('toastr')}}">
                            <i class="nav-icon i-Bell"></i>
                            <span class="item-name">Toastr</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='sweetAlert' ? 'open' : '' }}" href="{{route('sweetAlert')}}">
                            <i class="nav-icon i-Approved-Window"></i>
                            <span class="item-name">Sweet Alerts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='tour' ? 'open' : '' }}" href="{{route('tour')}}">
                            <i class="nav-icon i-Plane"></i>
                            <span class="item-name">User Tour</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='upload' ? 'open' : '' }}" href="{{route('upload')}}">
                            <i class="nav-icon i-Data-Upload"></i>
                            <span class="item-name">Upload</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="uikits">
                    <li class="nav-item">
                    <a class="{{ Route::currentRouteName()=='alerts' ? 'open' : '' }}" href="{{route('alerts')}}">
                            <i class="nav-icon i-Bell1"></i>
                            <span class="item-name">Alerts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                            <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                            <span class="item-name">Accordion</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='badges' ? 'open' : '' }}" href="{{route('badges')}}">
                            <i class="nav-icon i-Medal-2"></i>
                            <span class="item-name">Badges</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='buttons' ? 'open' : '' }}" href="{{route('buttons')}}">
                            <i class="nav-icon i-Cursor-Click"></i>
                            <span class="item-name">Buttons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='cards' ? 'open' : '' }}" href="{{route('cards')}}">
                            <i class="nav-icon i-Line-Chart-2"></i>
                            <span class="item-name">Cards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='cards-metrics' ? 'open' : '' }}" href="{{route('cards-metrics')}}">
                            <i class="nav-icon i-ID-Card"></i>
                            <span class="item-name">Card Metrics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='carousel' ? 'open' : '' }}" href="{{route('carousel')}}">
                            <i class="nav-icon i-Video-Photographer"></i>
                            <span class="item-name">Carousels</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='lists' ? 'open' : '' }}" href="{{route('lists')}}">
                            <i class="nav-icon i-Belt-3"></i>
                            <span class="item-name">Lists</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='pagination' ? 'open' : '' }}" href="{{route('pagination')}}">
                            <i class="nav-icon i-Arrow-Next"></i>
                            <span class="item-name">Paginations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='popover' ? 'open' : '' }}" href="{{route('popover')}}">
                            <i class="nav-icon i-Speach-Bubble-2"></i>
                            <span class="item-name">Popover</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='progressbar' ? 'open' : '' }}" href="{{route('progressbar')}}">
                            <i class="nav-icon i-Loading"></i>
                            <span class="item-name">Progressbar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='tables' ? 'open' : '' }}" href="{{route('tables')}}">
                            <i class="nav-icon i-File-Horizontal-Text"></i>
                            <span class="item-name">Tables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='tabs' ? 'open' : '' }}" href="{{route('tabs')}}">
                            <i class="nav-icon i-New-Tab"></i>
                            <span class="item-name">Tabs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='tooltip' ? 'open' : '' }}" href="{{route('tooltip')}}">
                            <i class="nav-icon i-Speach-Bubble-8"></i>
                            <span class="item-name">Tooltip</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='modals' ? 'open' : '' }}" href="{{route('modals')}}">
                            <i class="nav-icon i-Duplicate-Window"></i>
                            <span class="item-name">Modals</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='NoUislider' ? 'open' : '' }}" href="{{route('NoUislider')}}">
                            <i class="nav-icon i-Width-Window"></i>
                            <span class="item-name">Sliders</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="sessions">
                    <li class="nav-item">
                        <a href="{{route('signIn')}}">
                            <i class="nav-icon i-Checked-User"></i>
                            <span class="item-name">Sign in</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('signUp')}}">
                            <i class="nav-icon i-Add-User"></i>
                            <span class="item-name">Sign up</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('forgot')}}">
                            <i class="nav-icon i-Find-User"></i>
                            <span class="item-name">Forgot</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="others">
                    <li class="nav-item">
                        <a href="{{route('notFound')}}">
                            <i class="nav-icon i-Error-404-Window"></i>
                            <span class="item-name">Not Found</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='user-profile' ? 'open' : '' }}" href="{{route('user-profile')}}">
                            <i class="nav-icon i-Male"></i>
                            <span class="item-name">User Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='starter' ? 'open' : '' }}" href="{{route('starter')}}" class="open">
                            <i class="nav-icon i-File-Horizontal"></i>
                            <span class="item-name">Blank Page</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!--=============== Left side End ================-->
