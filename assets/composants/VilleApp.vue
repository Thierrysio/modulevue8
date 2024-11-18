<template>
    <div class="villes-app">
      <h1>Tableau des Villes</h1>
      <div class="table-container">
        <div class="table-header">
          <div>ID</div>
          <div>Nom</div>
          <div>Pays</div>
          <div>Actions</div>
        </div>
        <div class="table-row" v-for="ville in villes" :key="ville.id">
          <div>{{ ville.id }}</div>
          <div>{{ ville.nom }}</div>
          <div>{{ ville.pays }}</div>
          <div>
            <button @click="deleteVille(ville.id)">Supprimer</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  
  export default {
    name: 'VillesApp',
    setup() {
      const villes = ref([]);
  
      // Fonction pour récupérer les données des villes
      const fetchVilles = async () => {
        try {
          const response = await fetch('/api/villes');
          if (!response.ok) {
            throw new Error('Erreur lors du chargement des villes');
          }
          villes.value = await response.json();
        } catch (error) {
          console.error(error);
        }
      };
  
      // Fonction pour supprimer une ville
      const deleteVille = async (id) => {
        try {
          const response = await fetch(`/api/villes/delete/${id}`, {
            method: 'DELETE',
          });
          if (!response.ok) {
            throw new Error('Erreur lors de la suppression de la ville');
          }
          // Rafraîchir la liste après suppression
          await fetchVilles();
        } catch (error) {
          console.error(error);
        }
      };
  
      // Charger les villes au montage du composant
      onMounted(() => {
        fetchVilles();
      });
  
      return {
        villes,
        deleteVille,
      };
    },
  };
  </script>
  
  <style scoped>
  .villes-app {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
  }
  
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .table-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .table-header,
  .table-row {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
  }
  
  .table-header {
    font-weight: bold;
    background-color: #e9e9e9;
  }
  
  .table-row:nth-child(even) {
    background-color: #f4f4f4;
  }
  
  button {
    padding: 5px 10px;
    background-color: #d9534f;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #c9302c;
  }
  </style>
  