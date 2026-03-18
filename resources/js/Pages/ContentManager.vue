<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted } from "vue";
import axios from "axios";

const items = ref([]);
const form = ref({
    id: null,
    type: "feature",
    title: "",
    body: "",
    image: "",
});

const fetchItems = async () => {
    const res = await axios.get("/api/contents");
    items.value = res.data;
};

const save = async () => {
    await axios.post("/api/contents", form.value);
    await fetchItems();

    form.value = {
        id: null,
        type: "feature",
        title: "",
        body: "",
        image: "",
    };
};

const editItem = (item) => {
    form.value = { ...item };
};

const deleteItem = async (id) => {
    if (!confirm("削除する？")) return;

    await axios.delete(`/api/contents/${id}`);
    await fetchItems();
};

onMounted(fetchItems);
</script>

<template>
    <AppLayout>
        <div class="container">
            <h2>記事管理</h2>

            <div class="bg-white p-6 rounded shadow mb-6">
                <div class="grid grid-cols-1 gap-4">
                    <select v-model="form.type" class="border p-2">
                        <option value="feature">特集</option>
                        <option value="news">NEWS</option>
                    </select>

                    <input
                        v-model="form.title"
                        placeholder="タイトル"
                        class="border p-2"
                    />

                    <textarea
                        v-model="form.body"
                        placeholder="本文"
                        class="border p-2 h-32"
                    ></textarea>

                    <input
                        v-model="form.image"
                        placeholder="画像URL"
                        class="border p-2"
                    />

                    <button
                        @click="save"
                        class="bg-black text-white px-4 py-2 w-32"
                    >
                        保存
                    </button>
                </div>
            </div>

            <table class="w-full border mt-6">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">種別</th>
                        <th class="p-2 text-left">タイトル</th>
                        <th class="p-2 text-left">操作</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td class="p-2">{{ item.id }}</td>
                        <td class="p-2">{{ item.type }}</td>
                        <td class="p-2">{{ item.title }}</td>
                        <td class="p-2">
                            <button
                                @click="editItem(item)"
                                class="bg-gray-800 text-white px-2 py-1"
                            >
                                編集
                            </button>
                            <button
                                @click="deleteItem(item.id)"
                                class="bg-red-500 text-white px-2 py-1 ml-2"
                            >
                                削除
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
