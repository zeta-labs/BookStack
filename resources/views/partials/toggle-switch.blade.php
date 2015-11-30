
<script type="x-template" id="toggle-switch">
    <div class="toggle-switch" @click="switch" :class="{'active': isActive}">
        <input type="hidden" :name="name" :value="value"/>
        <div class="switch-handle"></div>
    </div>
</script>