<script type="x-template" id="image-picker">
    <div class="image-picker">
        <div>
            <img v-if="image && image !== 'none'" :src="image" :class="imageClass" alt="Image Preview">
            <img v-if="image === '' && defaultImage" :src="defaultImage" :class="imageClass" alt="Image Preview">
        </div>
        <button class="button" type="button" @click="showImageManager">Select Image</button>
        <br>
        <button class="text-button" @click="reset" type="button">Reset</button> <span class="sep">|</span> <button class="text-button neg" @click="remove" type="button">Remove</button>
        <input type="hidden" :name="name" :id="name" v-model="image">
    </div>
</script>