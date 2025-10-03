import axios from 'axios';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  timeout: 10000 // 10 detik timeout
});

// Interceptor untuk request (opsional, untuk menambahkan token dll)
apiClient.interceptors.request.use(
  (config) => {
    // Bisa tambahkan token di sini jika perlu
    // const token = localStorage.getItem('token');
    // if (token) {
    //   config.headers.Authorization = `Bearer ${token}`;
    // }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Interceptor untuk response (opsional, untuk handle error global)
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    // Handle error global di sini
    if (error.response) {
      // Server merespon dengan status code diluar range 2xx
      console.error('Response Error:', error.response.data);
    } else if (error.request) {
      // Request dibuat tapi tidak ada response
      console.error('Request Error:', error.request);
    } else {
      // Error lainnya
      console.error('Error:', error.message);
    }
    return Promise.reject(error);
  }
);

// Interface untuk type safety
export interface VisiMisi {
  id: number
  judul?: string
  visi: string
  misi: string
  gambar?: string
}
export interface Kontak {
  id: number;
  alamat: string;
  telepon: string;
  email: string;
  maps_link: string;
}

export interface Testimoni {
  id: number;
  nama_client: string;
  instansi: string;
  isi: string;
  tanggal: string;
}

export interface Riwayat {
  id: number;
  judul: string;
  deskripsi: string;
  tahun: string;
}

export interface OurClient {
  id: number;
  nama_client: string;
  instansi: string;
  logo: string;
}

export interface Produk {
  id: number;
  nama: string;
  deskripsi: string;
  gambar: string;
  harga: number;
  client_id: number;
}

// API Service
export default {
  // ===== VISI MISI =====
  async getVisiMisi() {
    try {
      const response = await apiClient.get<VisiMisi>('/visi-misi');
      return response.data;
    } catch (error) {
      console.error('Error fetching visi misi:', error);
      throw error;
    }
  },

  // ===== KONTAK =====
  async getKontak() {
    try {
      const response = await apiClient.get<Kontak>('/kontak');
      return response.data;
    } catch (error) {
      console.error('Error fetching kontak:', error);
      throw error;
    }
  },

  // ===== TESTIMONI =====
  async getTestimoni() {
    try {
      const response = await apiClient.get<Testimoni[]>('/testimoni');
      return response.data;
    } catch (error) {
      console.error('Error fetching testimoni:', error);
      throw error;
    }
  },

  async getTestimoniById(id: number) {
    try {
      const response = await apiClient.get<Testimoni>(`/testimoni/${id}`);
      return response.data;
    } catch (error) {
      console.error('Error fetching testimoni by id:', error);
      throw error;
    }
  },

  // ===== RIWAYAT =====
  async getRiwayat() {
    try {
      const response = await apiClient.get<Riwayat[]>('/riwayat');
      return response.data;
    } catch (error) {
      console.error('Error fetching riwayat:', error);
      throw error;
    }
  },

  async getRiwayatById(id: number) {
    try {
      const response = await apiClient.get<Riwayat>(`/riwayat/${id}`);
      return response.data;
    } catch (error) {
      console.error('Error fetching riwayat by id:', error);
      throw error;
    }
  },

  // ===== OUR CLIENT =====
  async getOurClient() {
    try {
      const response = await apiClient.get<OurClient[]>('/our-client');
      return response.data;
    } catch (error) {
      console.error('Error fetching our client:', error);
      throw error;
    }
  },

  async getOurClientById(id: number) {
    try {
      const response = await apiClient.get<OurClient>(`/our-client/${id}`);
      return response.data;
    } catch (error) {
      console.error('Error fetching our client by id:', error);
      throw error;
    }
  },

  // ===== PRODUK =====
  async getProduk() {
    try {
      const response = await apiClient.get<Produk[]>('/produk');
      return response.data;
    } catch (error) {
      console.error('Error fetching produk:', error);
      throw error;
    }
  },

  async getProdukById(id: number) {
    try {
      const response = await apiClient.get<Produk>(`/produk/${id}`);
      return response.data;
    } catch (error) {
      console.error('Error fetching produk by id:', error);
      throw error;
    }
  },

  async getProdukByClient(clientId: number) {
    try {
      const response = await apiClient.get<Produk[]>(`/produk/client/${clientId}`);
      return response.data;
    } catch (error) {
      console.error('Error fetching produk by client:', error);
      throw error;
    }
  }
};
