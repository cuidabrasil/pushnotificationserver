<style>
    .skin-blue .sidebar-menu > li.header {
        color: #8cadbb;
        background: #1a2226;
    }
</style>
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}">
        <img src="{{ url('/') }}/public/images/ic_usuariosdosistema.svg" style="width: 14px;margin-right: 5px;" />
        <span>Usuários Sistema</span>
    </a>
</li>
<li class="{{ Request::is('dashboard') ? 'active' : '' }}">
    <a href="{!! route('dashboard') !!}">
        <img src="{{ url('/') }}/public/images/ic_cursoscalendario.svg" style="width: 14px;margin-right: 5px;" />
        <span>Dashboard</span>
    </a>
</li>
<script>
    var _toggle = 1;
    $(".sidebar-toggle").on("click", function(){
        console.log(_toggle);
        if ( _toggle == 1 ) {
            _toggle = 0;
        } else {
            _toggle = 1;
        }
        if ( _toggle == 0 ) {
            $(".menu-logo").hide();
        } else {
            $(".menu-logo").show();
        }
    });
</script>
