<template>
  <div class="product-app">
    <h1>Gestion des Produits</h1>
    <form @submit.prevent="submitForm">
      <input v-model="newProduct.name" placeholder="Nom du produit" required>
      <input v-model="newProduct.description" placeholder="Description" required>
      <input v-model.number="newProduct.price" placeholder="Prix" required>
      <button type="submit">{{ isEditing ? 'Mettre à jour' : 'Ajouter' }}</button>
      <button type="button" v-if="isEditing" @click="cancelEdit">Annuler</button>
    </form>

    <ul>
      <li v-for="product in products" :key="product.id">
        <div class="product-item">
          <div class="product-info">
            <strong>{{ product.name }}</strong>
            <span>{{ product.description }}</span>
            <span>{{ product.price }}€</span>
          </div>
          <div class="product-actions">
            <button class="btn-delete" @click="deleteProduct(product.id)">Supprimer</button>
            <button class="btn-edit" @click="editProduct(product)">Modifier</button>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>


<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {
  name: 'ProductApp',
  setup() {
    const products = ref([]);
    const newProduct = ref({
      name: '',
      description: '',
      price: 0,
    });
    const isEditing = ref(false);
    const editingProductId = ref(null);
    const intervalId = ref(null);

    const fetchProducts = async () => {
      try {
        const response = await fetch('/api/products/');
        if (!response.ok) {
          throw new Error('Erreur lors du chargement des produits');
        }
        products.value = await response.json();
      } catch (error) {
        console.error(error);
      }
    };

    const submitForm = async () => {
      if (isEditing.value) {
        await updateProduct();
      } else {
        await addProduct();
      }
    };

    const addProduct = async () => {
      try {
        const response = await fetch('/api/product/add', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(newProduct.value),
        });

        if (!response.ok) {
          throw new Error('Erreur lors de l\'ajout du produit');
        }

        await fetchProducts();
        newProduct.value = { name: '', description: '', price: 0 };
      } catch (error) {
        console.error(error);
      }
    };

    const deleteProduct = async (id) => {
      try {
        const response = await fetch(`/api/product/delete/${id}`, {
          method: 'DELETE',
        });

        if (!response.ok) {
          throw new Error('Erreur lors de la suppression du produit');
        }

        await fetchProducts();
      } catch (error) {
        console.error(error);
      }
    };

    const editProduct = (product) => {
      newProduct.value = { ...product }; // Cloner le produit pour éviter les références
      isEditing.value = true;
      editingProductId.value = product.id;
    };

    const cancelEdit = () => {
      isEditing.value = false;
      editingProductId.value = null;
      newProduct.value = { name: '', description: '', price: 0 };
    };

    const updateProduct = async () => {
      try {
        const response = await fetch(`/api/product/update/${editingProductId.value}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(newProduct.value),
        });

        if (!response.ok) {
          throw new Error('Erreur lors de la mise à jour du produit');
        }

        await fetchProducts();
        isEditing.value = false;
        editingProductId.value = null;
        newProduct.value = { name: '', description: '', price: 0 };
      } catch (error) {
        console.error(error);
      }
    };

    onMounted(() => {
      fetchProducts();
      intervalId.value = setInterval(fetchProducts, 2000);
    });

    onUnmounted(() => {
      clearInterval(intervalId.value);
    });

    return {
      products,
      newProduct,
      isEditing,
      submitForm,
      addProduct,
      deleteProduct,
      editProduct,
      cancelEdit,
    };
  },
};
</script>

<style scoped>
.product-app {
  max-width: 600px;
  margin: 0 auto;
}

form {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

input {
  margin-bottom: 10px;
  padding: 8px;
}

button {
  padding: 10px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin-bottom: 10px;
}

.product-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.product-info {
  display: flex;
  flex-direction: column;
}

.product-info strong {
  font-size: 1.1em;
}

.product-info span {
  margin-top: 4px;
}

.product-actions {
  display: flex;
  gap: 10px;
}

.btn-delete {
  background-color: #e74c3c;
  color: #fff;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
}

.btn-edit {
  background-color: #3498db;
  color: #fff;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
}

.btn-delete:hover {
  background-color: #c0392b;
}

.btn-edit:hover {
  background-color: #2980b9;
}

button[type="submit"] {
  background-color: #2ecc71;
  color: #fff;
  border: none;
  margin-bottom: 10px;
  cursor: pointer;
  border-radius: 4px;
}

button[type="submit"]:hover {
  background-color: #27ae60;
}

button[type="button"] {
  background-color: #95a5a6;
  color: #fff;
  border: none;
  cursor: pointer;
  border-radius: 4px;
}

button[type="button"]:hover {
  background-color: #7f8c8d;
}
</style>
