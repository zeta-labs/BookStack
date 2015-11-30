<div id="image-manager">
    <div class="overlay" v-el:overlay @click="overlayClick">
        <div class="image-manager-body">
            <div class="image-manager-content">
                <div class="image-manager-list">
                    <div v-for="image in images">
                        <img class="anim fadeIn"
                             :class="{selected: (image==selectedImage)}"
                             :src="image.thumbnail" :alt="image.title" :title="image.name"
                        @click="imageClick(image)"
                        :style="{animationDelay: ($index > 26) ? '160ms' : ($index * 25) + 'ms'}">
                    </div>
                    <div class="load-more" v-show="hasMore" @click="fetchData">Load More</div>
            </div>
        </div>
        <button class="neg button image-manager-close" @click="hide">x</button>
        <div class="image-manager-sidebar">
            <h2 v-el:image-title>Images</h2>
            <hr class="even">
            <div class="dropzone-container" v-el:drop-zone>
                <div class="dz-message">Drop files or click here to upload</div>
            </div>
            <div class="image-manager-details anim fadeIn" v-show="selectedImage">
                <hr class="even">
                <form @submit="saveImageDetails" v-el:image-form>
                <div class="form-group">
                    <label for="name">Image Name</label>
                    <input type="text" id="name" name="name" v-model="selectedImage.name">
                </div>
                </form>
                <hr class="even">
                <div v-show="dependantPages">
                    <p class="text-neg text-small">
                        This image is used in the pages below, Click delete again to confirm you want to delete
                        this image.
                    </p>
                    <ul class="text-neg">
                        <li v-for="page in dependantPages">
                            <a :href="page.url" target="_blank" class="text-neg">@{{ page.name }}</a>
                        </li>
                    </ul>
                </div>

                <form @submit="deleteImage" v-el:image-delete-form>
                    <button class="button neg">@icon('delete')Delete Image</button>
                </form>
            </div>
            <div class="image-manager-bottom">
                <button class="button pos anim fadeIn" v-show="selectedImage" @click="selectButtonClick">Select Image
                </button>
            </div>
        </div>
    </div>
</div>