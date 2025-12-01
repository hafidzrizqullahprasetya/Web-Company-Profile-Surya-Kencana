<template>
    <div class="w-full h-full rounded-xl overflow-hidden shadow-lg bg-gray-100 relative">
        <iframe v-if="searchQuery" :key="searchQuery" :src="embedUrl" width="100%" height="100%" style="border: 0"
            allowfullscreen loading="lazy" referrerpolicy="origin" class="w-full h-full"
            title="Google Maps Location"></iframe>

        <div v-else class="flex flex-col items-center justify-center h-full text-gray-400 p-6 bg-gray-200">
            <i class="fa-solid fa-map-location-dot text-4xl mb-2"></i>
            <span class="text-sm font-medium">{{ debugMessage }}</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, watch } from 'vue'
import { useMapParser } from '@/composables/useMapParser'

interface Props {
    mapInput: string
    apiKey: string
}

const props = defineProps<Props>()

const { parseMapLink } = useMapParser()

const searchQuery = computed(() => {
    const parsed = parseMapLink(props.mapInput)
    console.log('[GoogleMapEmbed] Input:', props.mapInput)
    console.log('[GoogleMapEmbed] Parsed Query:', parsed)
    return parsed
})

const embedUrl = computed(() => {
    if (!searchQuery.value) return ''
    const url = `https://www.google.com/maps/embed/v1/place?key=${props.apiKey}&q=${encodeURIComponent(searchQuery.value)}`
    console.log('[GoogleMapEmbed] Embed URL:', url)
    return url
})

const debugMessage = computed(() => {
    if (!props.mapInput) return 'No location provided'
    if (!props.apiKey) return 'API Key not configured'
    return 'Location tidak ditemukan'
})

watch(
    () => props.mapInput,
    (newInput) => {
        console.log('[GoogleMapEmbed] Map input changed:', newInput)
    }
)
</script>
