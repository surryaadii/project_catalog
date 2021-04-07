<template>
    <transition name="modal">
        <div class="modal-mask" v-if="isShowing">
            <div class="modal-wrapper" @click.self="$emit('close')">
                <div class="modal-container">
                    <slot name="float-button-close"></slot>
                    <div class="modal-header" v-if="showHeader">
                        <slot name="header">
                            default header
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>

                    <div class="modal-footer" v-if="showFooter">
                        <slot name="footer">
                            default footer
                            <button class="modal-default-button" @click="$emit('close')">
                                OK
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: [
        "showFooter",
        "showHeader",
        "isShowing",
    ]
};
</script>