<template>
  <AppLayout title="おすすめ商品管理">
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">おすすめ商品 管理</h1>

<form @submit.prevent="saveItem" class="flex flex-wrap gap-2 mb-6">
  <input
    v-model="form.base_item_id"
    placeholder="BASE商品ID（空欄＝共通）"
    class="border p-2 w-1/4"
  >

  <input
    v-model="form.title"
    placeholder="タイトル"
    class="border p-2 w-1/4"
    required
  >

  <input
    v-model="form.image_url"
    placeholder="画像URL"
    class="border p-2 w-1/4"
  >

  <input
    v-model="form.url"
    placeholder="リンクURL"
    class="border p-2 w-1/4"
  >

  <button
    type="submit"
    class="bg-blue-600 text-white px-4 py-2 rounded"
  >
    {{ editing ? '更新' : '追加' }}
  </button>
</form>


      <table class="w-full border-collapse border text-sm">
        <thead>
          <tr class="bg-gray-100">
            <th class="border p-2">対象商品</th>
            <th class="border p-2">ID</th>
            <th class="border p-2">タイトル</th>
            <th class="border p-2">画像</th>
            <th class="border p-2">URL</th>
            <th class="border p-2 w-32">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items" :key="item.id">
            <td class="border p-2 text-center">
              <span
                v-if="item.base_item_id"
                class="text-sm text-blue-600 font-mono"
              >
                {{ item.base_item_id }}
              </span>
              <span
                v-else
                class="text-sm text-gray-400"
              >
                共通
              </span>
            </td>
            <td class="border p-2">{{ item.id }}</td>
            <td class="border p-2">{{ item.title }}</td>
            <td class="border p-2">
              <img v-if="item.image_url" :src="item.image_url" class="h-10 mx-auto">
            </td>
            <td class="border p-2 truncate">{{ item.url }}</td>
            <td class="border p-2 text-center">
              <button @click="edit(item)" class="text-blue-600 mr-2">編集</button>
              <button @click="remove(item.id)" class="text-red-600">削除</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import axios from "axios"

const items = ref([])
const editing = ref(false)
const editingId = ref(null)
const form = ref({
  base_item_id: "",
  title: "",
  image_url: "",
  url: "",
})

const load = async () => {
  const res = await axios.get("/api/admin/recommend-items/all")
  items.value = res.data
}

const saveItem = async () => {
  try {
    if (editing.value) {
      await axios.put(`/api/recommend-items/${editingId.value}`, form.value)
    } else {
      await axios.post("/api/recommend-items", form.value)
    }
    resetForm()
    await load()
    alert("保存しました！")
  } catch (e) {
    console.error("保存時エラー:", e.response?.data || e)
    alert("保存に失敗しました")
  }
}

const edit = (item) => {
  editing.value = true
  editingId.value = item.id
  form.value = {
    base_item_id: item.base_item_id || "",
    title: item.title,
    image_url: item.image_url,
    url: item.url,
  }
}


const remove = async (id) => {
  if (confirm("削除しますか？")) {
    await axios.delete(`/api/recommend-items/${id}`)
    load()
  }
}

const resetForm = () => {
  editing.value = false
  editingId.value = null
  form.value = {
    base_item_id: "",
    title: "",
    image_url: "",
    url: "",
  }
}


onMounted(load)
</script>

<style scoped>
table img { object-fit: contain; }
</style>
