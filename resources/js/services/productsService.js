// resources/js/services/bannerService.js
import api from "./api";

export const getProducts = async () => {
    const { data } = await api.get("productos");
    return data;
};

export const getProductDetail = async (slug) => {
    const { data } = await api.get(`producto/${slug}`);
    return data;
};
