const create = async (data) => {
    try {
        let results = await axios.post('/api/comment/create', data);
        return results;
    } catch (error) {
        console.error('Lỗi khi gửi lời chúc', error);
        throw error;
    }
};
const index = async (data) => {
    try {
        let results = await axios.post('/api/comment');
        return results;
    } catch (error) {
        console.error('Lỗi lấy tất cả dữ liệu comment', error);
        throw error;
    }
}

const update = async (data) => {
    try {
        let results = await axios.post(`/api/comment/update/${data['id']}`, data);
        return results;
    } catch (error) {
        console.error('Lỗi khi updated dữ liệu comment', error);
        throw error;
    }
}

const remove = async (id) => {
    try {
        let results = await axios.post(`/api/comment/delete/${id}`);
        return results;
    } catch (error) {
        console.error('Lỗi khi delete dữ liệu comment', error);
        throw error;
    }
}

export default{ 
    create,
    index,
    update,
    remove
};