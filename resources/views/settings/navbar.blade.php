
<div class="faded-small">
    <div class="container">
        <div class="row">
            <div class="col-md-12 setting-nav">
                <a href="/settings" @if($selected == 'settings') class="selected text-button" @endif>@icon('settings')Settings</a>
                <a href="/users" @if($selected == 'users') class="selected text-button" @endif>@icon('users')Users</a>
            </div>
        </div>
    </div>
</div>