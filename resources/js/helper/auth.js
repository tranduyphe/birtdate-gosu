const login = async (data) => {
    let result = await axios
    .post('/api/login', {
        email: data.email,
        password: data.password,
    });
    return result;
};

const logout = async (token) => {
    let header = {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer '+token,
    }
    let result = await axios
    .post('/api/logout', header);
    return result;
};

export { login, logout };