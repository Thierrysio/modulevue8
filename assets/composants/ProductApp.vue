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
        <strong>{{ product.name }}</strong> - {{ product.description }} - {{ product.price }}€
        <button @click="deleteProduct(product.id)">Supprimer</button>
        <button @click="editProduct(product)">Modifier</button>
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
</style>
