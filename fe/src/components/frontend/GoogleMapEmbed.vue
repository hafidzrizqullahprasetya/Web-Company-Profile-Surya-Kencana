<template>
    <div class="w-full h-full rounded-xl overflow-hidden shadow-lg bg-gray-100 relative">
        <iframe v-if="embedUrl" :key="embedUrl" :src="embedUrl" width="100%" height="100%" style="border: 0"
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
import { useMapParser, type ParsedMapData } from '@/composables/useMapParser'

interface Props {
    mapInput: string
    apiKey: string
}

const props = defineProps<Props>()

const { parseMapLink } = useMapParser()

const parsedData = computed(() => {
    const parsed = parseMapLink(props.mapInput)
    return parsed
})

const embedUrl = computed(() => {
    if (!props.apiKey) return ''
    if (parsedData.value.type === 'invalid' || !parsedData.value.value) return ''

    let url = ''

    if (parsedData.value.type === 'coordinates') {
        // For coordinates, use the place endpoint with coordinates
        url = `https://www.google.com/maps/embed/v1/place?key=${props.apiKey}&q=${encodeURIComponent(parsedData.value.value)}`
    } else if (parsedData.value.type === 'url' && parsedData.value.value.startsWith('https://')) {
        // For Google Maps URLs, we need to extract the place information differently
        // We'll redirect to a search based on the URL content
        const urlObj = new URL(parsedData.value.value)
        const placeName = urlObj.pathname.split('/place/')[1]?.split('/')[0]?.replace(/\+/g, ' ')
        if (placeName) {
            url = `https://www.google.com/maps/embed/v1/place?key=${props.apiKey}&q=${encodeURIComponent(decodeURIComponent(placeName))}`
        } else {
            // If we can't extract place name from URL, use the original input
            url = `https://www.google.com/maps/embed/v1/place?key=${props.apiKey}&q=${encodeURIComponent(props.mapInput)}`
        }
    } else {
        // For location names, use the search endpoint
        url = `https://www.google.com/maps/embed/v1/place?key=${props.apiKey}&q=${encodeURIComponent(parsedData.value.value)}`
    }

    return url
})

const debugMessage = computed(() => {
    if (!props.mapInput) return 'No location provided'
    if (!props.apiKey) return 'API Key not configured'
    if (parsedData.value.type === 'invalid') return 'Invalid location format'
    return 'Location tidak ditemukan'
})

watch(
    () => props.mapInput,
    (newInput) => {
        // Map input changed
    }
)
</script>
