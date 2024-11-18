<template>
    <div class="fournisseurs-app">
      <h1>Tableau des Fournisseurs - Famille Alimentaire</h1>
      <div class="table-container">
        <div class="table-header">
          <div>ID</div>
          <div>Nom</div>
          <div>Famille de Produit</div>
        </div>
        <div class="table-row" v-for="fournisseur in filteredFournisseurs" :key="fournisseur.id">
          <div>{{ fournisseur.id }}</div>
          <div>{{ fournisseur.nom }}</div>
          <div>{{ fournisseur.familleDeProduit }}</div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, computed, onMounted } from 'vue';
  
  export default {
    name: 'FournisseursApp',
    setup() {
      const fournisseurs = ref([]);
  
      // Fonction pour récupérer les données des fournisseurs
      const fetchFournisseurs = async () => {
        try {
          const response = await fetch('/api/fournisseurs');
          if (!response.ok) {
            throw new Error('Erreur lors du chargement des fournisseurs');
          }
          fournisseurs.value = await response.json();
        } catch (error) {
          console.error(error);
        }
      };
  
      // Filtrer les fournisseurs pour ne garder que ceux de la famille "alimentaire"
      const filteredFournisseurs = computed(() =>
        fournisseurs.value.filter(fournisseur => fournisseur.familleDeProduit === 'alimentaire')
      );
  
      // Charger les fournisseurs au montage du composant
      onMounted(() => {
        fetchFournisseurs();
      });
  
      return {
        fournisseurs,
        filteredFournisseurs,
      };
    },
  };
  </script>
  
  <style scoped>
  .fournisseurs-app {
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
  </style>
  