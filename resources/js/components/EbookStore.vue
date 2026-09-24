<script setup>
import { computed, reactive, ref } from 'vue'

const props = defineProps({
    ebooks: {
        type: Array,
        required: true,
    },
    checkoutUrl: {
        type: String,
        required: true,
    },
})

const quantities = reactive(
    props.ebooks.reduce((carry, ebook) => {
        carry[ebook.id] = 1
        return carry
    }, {})
)

const cart = ref([])
const isSubmitting = ref(false)
const successOrder = ref(null)
const errors = ref({})
const form = reactive({
    customer_name: '',
    customer_email: '',
})

const currency = new Intl.NumberFormat('cs-CZ', {
    style: 'currency',
    currency: 'CZK',
})

const cartTotal = computed(() => cart.value.reduce((sum, item) => sum + (Number(item.price) * item.quantity), 0))

function addToCart(ebook) {
    const quantity = Math.max(1, Number(quantities[ebook.id] || 1))
    const existingItem = cart.value.find(item => item.id === ebook.id)

    if (existingItem) {
        existingItem.quantity += quantity
        return
    }

    cart.value.push({
        id: ebook.id,
        title: ebook.title,
        author: ebook.author,
        price: Number(ebook.price),
        quantity,
    })
}

function updateQuantity(item, delta) {
    item.quantity = Math.max(1, item.quantity + delta)
}

function removeFromCart(ebookId) {
    cart.value = cart.value.filter(item => item.id !== ebookId)
}

async function submitOrder() {
    if (!cart.value.length || isSubmitting.value) {
        return
    }

    isSubmitting.value = true
    errors.value = {}

    try {
        const response = await window.axios.post(props.checkoutUrl, {
            customer_name: form.customer_name,
            customer_email: form.customer_email,
            items: cart.value.map(item => ({
                ebook_id: item.id,
                quantity: item.quantity,
            })),
        })

        successOrder.value = response.data
        cart.value = []
        form.customer_name = ''
        form.customer_email = ''
    } catch (error) {
        errors.value = error?.response?.data?.errors || {
            general: ['Objednávku se nepodařilo odeslat. Zkuste to prosím znovu.'],
        }
    } finally {
        isSubmitting.value = false
    }
}
</script>

<template>
    <div class="py-4">
        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 mb-1">Eshop s ebooky</h1>
                        <p class="text-muted mb-0">Vyberte si digitální tituly a stáhněte je ihned po dokončení objednávky.</p>
                    </div>
                    <span class="badge text-bg-dark fs-6">{{ ebooks.length }} titulů</span>
                </div>

                <div class="row g-4">
                    <div
                        v-for="ebook in ebooks"
                        :key="ebook.id"
                        class="col-md-6"
                    >
                        <div class="card h-100 shadow-sm border-0">
                            <img
                                :src="ebook.cover_image || 'https://via.placeholder.com/640x360?text=Ebook'"
                                class="card-img-top"
                                :alt="ebook.title"
                                style="height: 220px; object-fit: cover;"
                            >
                            <div class="card-body d-flex flex-column">
                                <div class="mb-3">
                                    <h2 class="h4 mb-1">{{ ebook.title }}</h2>
                                    <p class="text-secondary mb-2">{{ ebook.author }}</p>
                                    <p class="card-text">{{ ebook.description }}</p>
                                </div>

                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <strong class="fs-4">{{ currency.format(Number(ebook.price)) }}</strong>
                                        <div class="input-group" style="max-width: 130px;">
                                            <span class="input-group-text">ks</span>
                                            <input
                                                v-model.number="quantities[ebook.id]"
                                                type="number"
                                                min="1"
                                                max="10"
                                                class="form-control"
                                            >
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        class="btn btn-primary w-100"
                                        @click="addToCart(ebook)"
                                    >
                                        Přidat do košíku
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 1rem;">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Košík</h2>

                        <div
                            v-if="!cart.length"
                            class="alert alert-light border mb-0"
                        >
                            Košík je zatím prázdný.
                        </div>

                        <div v-else>
                            <div
                                v-for="item in cart"
                                :key="item.id"
                                class="border rounded p-3 mb-3"
                            >
                                <div class="d-flex justify-content-between gap-3">
                                    <div>
                                        <h3 class="h6 mb-1">{{ item.title }}</h3>
                                        <p class="text-muted small mb-0">{{ item.author }}</p>
                                    </div>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        @click="removeFromCart(item.id)"
                                    >
                                        Odebrat
                                    </button>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" @click="updateQuantity(item, -1)">-</button>
                                        <button type="button" class="btn btn-outline-secondary disabled">{{ item.quantity }}</button>
                                        <button type="button" class="btn btn-outline-secondary" @click="updateQuantity(item, 1)">+</button>
                                    </div>
                                    <strong>{{ currency.format(item.price * item.quantity) }}</strong>
                                </div>
                            </div>

                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Celkem</span>
                                    <strong>{{ currency.format(cartTotal) }}</strong>
                                </div>

                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Jméno</label>
                                    <input id="customer_name" v-model="form.customer_name" type="text" class="form-control">
                                    <div v-if="errors.customer_name" class="text-danger small mt-1">{{ errors.customer_name[0] }}</div>
                                </div>

                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">E-mail</label>
                                    <input id="customer_email" v-model="form.customer_email" type="email" class="form-control">
                                    <div v-if="errors.customer_email" class="text-danger small mt-1">{{ errors.customer_email[0] }}</div>
                                </div>

                                <div v-if="errors.items" class="alert alert-danger py-2">
                                    {{ errors.items[0] }}
                                </div>

                                <div v-if="errors.general" class="alert alert-danger py-2">
                                    {{ errors.general[0] }}
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-success w-100"
                                    :disabled="isSubmitting"
                                    @click="submitOrder"
                                >
                                    {{ isSubmitting ? 'Odesílání...' : 'Dokončit objednávku' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="successOrder"
                    class="card mt-4 border-success shadow-sm"
                >
                    <div class="card-body">
                        <h2 class="h5 text-success">Objednávka hotová</h2>
                        <p class="mb-1">Číslo objednávky: <strong>{{ successOrder.order_number }}</strong></p>
                        <p class="mb-3">Celkem uhrazeno: <strong>{{ currency.format(Number(successOrder.total_price)) }}</strong></p>
                        <h3 class="h6">Odkazy ke stažení</h3>
                        <ul class="mb-0 ps-3">
                            <li v-for="download in successOrder.downloads" :key="download.title">
                                <a :href="download.download_url" target="_blank" rel="noreferrer">{{ download.title }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
