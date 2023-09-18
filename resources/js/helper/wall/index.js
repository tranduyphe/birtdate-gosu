const create = async (data) => {
    try {
        const formData = new FormData();
        formData.append('file', data.file);
        formData.append('title', data.title);
        formData.append('content', data.content);
        formData.append('color', data.color);
        let results = await axios.post('/api/wall/create', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        return results;
    } catch (error) {
        console.error('Lỗi khi gửi lời chúc', error);
        throw error;
    }
};
const index = async (data) => {
    try {
        let results = await axios.post('/api/wall');
        return results;
    } catch (error) {
        console.error('Lỗi lấy tất cả dữ liệu wall', error);
        throw error;
    }
}

const update = async (data) => {
    try {
        if (data.file) {
            const formData = new FormData();
            formData.append('file', data.file);
            formData.append('title', data.title);
            formData.append('content', data.content);
            formData.append('color', data.color);
            formData.append('id', data.id);
            let results = await axios.post(`/api/wall/update/${data['id']}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            return results;
        }
        let results = await axios.post(`/api/wall/update/${data['id']}`, data);
        return results;
    } catch (error) {
        console.error('Lỗi khi updated dữ liệu wall', error);
        throw error;
    }
}
export { 
    create,
    index,
    update
};