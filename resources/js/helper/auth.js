const login = async (data) => {
    try {
        await axios.get('/sanctum/csrf-cookie');
        let result = await axios.post('/api/login', {
            email: data.email,
            password: data.password,
        });

        return result;
    } catch (error) {
        console.error('Lỗi khi đăng nhập', error);
        throw error;
    }
};

const logout = async (token) => {    
    try {
        // let headers = {
        //     headers:{
        //         'Accept': 'application/json',
        //         'Authorization': 'Bearer '+token,
        //     }
        // }       
        let result = await axios.post('/api/logout', {}, {
            headers: {
              'Authorization': `Bearer ${token}` // Thay thế yourAccessToken bằng token xác thực của bạn
            }
        });
        return result;
    } catch (error) {
        console.error('Lỗi khi đăng xuất', error);
        throw error;
    }
};

export { login, logout };