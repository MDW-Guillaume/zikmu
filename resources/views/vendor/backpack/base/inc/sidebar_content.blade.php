{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('artist') }}"><i class="nav-icon la la-microphone-alt"></i> Artists</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('album') }}"><i class="nav-icon la la-compact-disc"></i> Albums</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('song') }}"><i class="nav-icon la la-music"></i> Songs</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('style') }}"><i class="nav-icon la la-layer-group"></i> Styles</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> Users</a></li>
