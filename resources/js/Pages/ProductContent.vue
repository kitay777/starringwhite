<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
const keyword = ref("");

// 検索付き取得
const fetchItems = async () => {
    const res = await axios.get("/api/products", {
        params: { keyword: keyword.value },
    });
    items.value = res.data;
};

// 削除
const deleteItem = async (id) => {
    if (!confirm("削除しますか？")) return;

    await axios.delete(`/api/products/${id}`);
    await fetchItems();
};

const items = ref([]);
const form = ref({
    base_item_id: "",
    description: "",
    size: "",
    note: "",
});

const loading = ref(false);

// 編集ロード
const editItem = (item) => {
    form.value = {
        base_item_id: item.base_item_id,
        description: item.description,
        size: item.size,
        note: item.note,
    };
};

// 保存
const save = async () => {
    loading.value = true;
    await axios.post("/api/products", form.value);
    await fetchItems();

    form.value = { base_item_id: "", description: "", size: "" };
    loading.value = false;
};

onMounted(fetchItems);
</script>

<template>
    <AppLayout title="商品詳細">
        <div class="container">
            <div style="margin-bottom: 20px">
                <input v-model="keyword" placeholder="商品IDで検索" />
                <button @click="fetchItems">検索</button>
            </div>
            <h2>商品設定</h2>

            <div class="form-box">
                <div class="form-row">
                    <label>商品ID</label>
                    <input v-model="form.base_item_id" />
                </div>

                <div class="form-row">
                    <label>商品説明</label>
                    <textarea v-model="form.description" rows="5"></textarea>
                </div>

                <div class="form-row">
                    <label>サイズ</label>
                    <textarea v-model="form.size" rows="3"></textarea>
                </div>

                <div class="form-row">
                    <label>備考</label>
                    <textarea v-model="form.note" rows="3"></textarea>
                </div>

                <button @click="save">保存</button>
            </div>

            <!-- 一覧 -->
            <table border="1" width="100%">
                <tr>
                    <th>ID</th>
                    <th>商品ID</th>
                    <th>操作</th>
                </tr>

                <tr v-for="item in items" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.base_item_id }}</td>
                    <td>
                        <button @click="editItem(item)">編集</button>
                        <button
                            @click="deleteItem(item.id)"
                            style="
                                margin-left: 10px;
                                background: red;
                                color: #fff;
                            "
                        >
                            削除
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </AppLayout>
</template>
<style>
.container {
    max-width: 900px;
    margin: 40px auto;
}

.form-box {
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 30px;
    background: #fff;
}

.form-row {
    margin-bottom: 15px;
}

input,
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
}

button {
    padding: 10px 20px;
    background: #000;
    color: #fff;
    border: none;
    cursor: pointer;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

table th {
    text-align: left;
    padding: 12px;
    background: #f5f5f5;
    font-weight: bold;
    border-bottom: 1px solid #ddd;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

table tr:hover {
    background: #fafafa;
}
</style>
