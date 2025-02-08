<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { Plus } from "@element-plus/icons-vue";

defineProps({
  products: Array, // Liste des produits existants (transmis par Inertia)
});

// Les catégories disponibles sont transmises via Inertia Page Props
const categories = usePage().props.categories;

// État pour ouvrir et fermer le formulaire
const isAddProduct = ref(false);
const editMode = ref(false);
const dialogVisible = ref(false);

// Champs de formulaire pour ajouter ou mettre à jour un produit
const id = ref("");
const name = ref(""); // Nom du produit
const description = ref(""); // Description
const size = ref(""); // Taille optionnelle
const stock = ref(0); // Quantité en stock
const price = ref(""); // Prix actuel
const old_price = ref(""); // Ancien prix
const category_id = ref(""); // ID de catégorie
const image = ref(null); // Image principale
const hover_image = ref(null); // Image au survol

// Méthode pour réinitialiser le formulaire
const resetFormData = () => {
  id.value = "";
  name.value = "";
  description.value = "";
  size.value = "";
  stock.value = 0;
  price.value = "";
  old_price.value = "";
  category_id.value = "";
  image.value = null;
  hover_image.value = null;
};

// Ouvrir le formulaire pour ajouter un produit
const openAddModal = () => {
  isAddProduct.value = true;
  dialogVisible.value = true;
  editMode.value = false;
  resetFormData();
};

// Ouvrir le formulaire pour modifier un produit
const openEditModal = (product) => {
  id.value = product.id;
  name.value = product.name;
  description.value = product.description;
  size.value = product.size;
  stock.value = product.stock;
  price.value = product.price;
  old_price.value = product.old_price;
  category_id.value = product.category_id;

  // Réinitialiser les images pour éviter tout problème lors des mises à jour
  image.value = null;
  hover_image.value = null;

  editMode.value = true;
  isAddProduct.value = false;
  dialogVisible.value = true;
};

// Méthode pour ajouter un produit
const addProduct = async () => {
  const formData = new FormData();
  formData.append("name", name.value);
  formData.append("description", description.value);
  formData.append("size", size.value);
  formData.append("stock", stock.value);
  formData.append("price", price.value);
  formData.append("old_price", old_price.value);
  formData.append("category_id", category_id.value);
  if (image.value) formData.append("image", image.value);
  if (hover_image.value) formData.append("hover_image", hover_image.value);

  try {
    await router.post("products/store", formData, {
      onSuccess: (page) => {
        Swal.fire({
          toast: true,
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          title: page.props.flash.success,
        });
        dialogVisible.value = false;
        resetFormData();
      },
    });
  } catch (err) {
    console.error(err);
  }
};

// Méthode pour mettre à jour un produit
const updateProduct = async () => {
  const formData = new FormData();
  formData.append("name", name.value);
  formData.append("description", description.value);
  formData.append("size", size.value);
  formData.append("stock", stock.value);
  formData.append("price", price.value);
  formData.append("old_price", old_price.value);
  formData.append("category_id", category_id.value);
  formData.append("_method", "PUT");
  if (image.value) formData.append("image", image.value);
  if (hover_image.value) formData.append("hover_image", hover_image.value);

  try {
    await router.post("products/update/" + id.value, formData, {
      onSuccess: (page) => {
        Swal.fire({
          toast: true,
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          title: page.props.flash.success,
        });
        dialogVisible.value = false;
        resetFormData();
      },
    });
  } catch (err) {
    console.error(err);
  }
};

// Supprimer une image spécifique de produit (fonctionalité API)
const deleteImage = async (imageType) => {
  try {
    await router.delete(`/products/image/${id.value}/${imageType}`, {
      onSuccess: (page) => {
        Swal.fire({
          toast: true,
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          title: page.props.flash.success,
        });
        if (imageType === "image") image.value = null;
        else if (imageType === "hover_image") hover_image.value = null;
      },
    });
  } catch (err) {
    console.error(err);
  }
};

// Méthode pour supprimer un produit
const deleteProduct = (productId, index) => {
  Swal.fire({
    title: "Are you sure?",
    text: "This action cannot be undone!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No",
    confirmButtonText: "Yes, Delete!",
  }).then((result) => {
    if (result.isConfirmed) {
      try {
        router.delete("products/destroy/" + productId, {
          onSuccess: (page) => {
            products.splice(index, 1); // Supprimer localement dans la table
            Swal.fire({
              toast: true,
              icon: "success",
              position: "top-end",
              showConfirmButton: false,
              title: page.props.flash.success,
            });
          },
        });
      } catch (err) {
        console.error(err);
      }
    }
  });
};
</script><template>
  <section class="p-3 sm:p-5">
    <!-- Dialog pour ajouter ou éditer un produit -->
    <el-dialog v-model="dialogVisible" :title="editMode ? 'Modifier un produit' : 'Ajouter un produit'" width="30%">
      <!-- Formulaire -->
      <form @submit.prevent="editMode ? updateProduct() : addProduct()">
        <!-- Nom du produit -->
        <div class="relative z-0 w-full mb-6 group">
          <input
              v-model="name"
              type="text"
              name="product_name"
              id="product_name"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              required
          />
          <label
              for="product_name"
              class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 peer-focus:text-blue-600"
          >
            Nom du produit
          </label>
        </div>

        <!-- Description du produit -->
        <div class="relative z-0 w-full mb-6 group">
          <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
          <textarea
              id="description"
              rows="4"
              v-model="description"
              class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Description du produit"
          ></textarea>
        </div>

        <!-- Prix -->
        <div class="grid grid-cols-2 gap-6">
          <div>
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Prix actuel</label>
            <input
                type="number"
                v-model="price"
                id="price"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Prix"
            />
          </div>
          <div>
            <label for="old_price" class="block mb-2 text-sm font-medium text-gray-900">Ancien prix</label>
            <input
                type="number"
                v-model="old_price"
                id="old_price"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Ancien prix"
            />
          </div>
        </div>

        <!-- Quantité en stock -->
        <div class="relative z-0 w-full mb-6 group">
          <label for="stock" class="block text-sm font-medium text-gray-900">Quantité en stock</label>
          <input
              v-model="stock"
              type="number"
              id="stock"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5"
              placeholder="0"
              required
          />
        </div>

        <!-- Taille -->
        <div class="relative z-0 w-full mb-6 group">
          <label for="size" class="block text-sm font-medium text-gray-900">Taille</label>
          <input
              v-model="size"
              type="text"
              id="size"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Taille (optionnel)"
          />
        </div>

        <!-- Catégorie -->
        <div>
          <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">Catégorie</label>
          <select
              id="category_id"
              v-model="category_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          >
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <!-- Image principale -->
        <div class="relative z-0 w-full mb-6 group">
          <label for="image" class="block text-sm font-medium text-gray-900">Image principale</label>
          <input
              type="file"
              id="image"
              @change="(e) => (image.value = e.target.files[0])"
              accept="image/*"
              class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
          />
        </div>

        <!-- Image au survol -->
        <div class="relative z-0 w-full mb-6 group">
          <label for="hover_image" class="block text-sm font-medium text-gray-900">Image au survol</label>
          <input
              type="file"
              id="hover_image"
              @change="(e) => (hover_image.value = e.target.files[0])"
              accept="image/*"
              class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
          />
        </div>

        <!-- Bouton de soumission -->
        <button
            type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
        >
          {{ editMode ? 'Mettre à jour' : 'Soumettre' }}
        </button>
      </form>
    </el-dialog>

    <!-- Liste des produits -->
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
      <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 bg-gray-50">
          <tr>
            <th scope="col" class="px-4 py-3">Nom</th>
            <th scope="col" class="px-4 py-3">Prix</th>
            <th scope="col" class="px-4 py-3">Catégorie</th>
            <th scope="col" class="px-4 py-3">Stock</th>
            <th scope="col" class="px-4 py-3">Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(product, index) in products" :key="product.id" class="border-b">
            <td class="px-4 py-3">{{ product.name }}</td>
            <td class="px-4 py-3">${{ product.price }}</td>
            <td class="px-4 py-3">{{ product.category.name }}</td>
            <td class="px-4 py-3">{{ product.stock }}</td>
            <td class="px-4 py-3 flex justify-end">
              <button @click="openEditModal(product)" class="text-blue-600 hover:underline">Modifier</button>
              <button @click="deleteProduct(product.id, index)" class="text-red-600 hover:underline ml-4">Supprimer</button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</template>
