export async function login(email: string, password: string) {
  const response = await fetch('http://127.0.0.1:8000/oauth/token', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      grant_type: 'password',
      client_id: '01975a88-3059-7060-baf3-94a1869b048a',
      client_secret: 'lQ6nWW65X6QrnwHi4MfyOaKuzLH5hI2YRK7aWmlg',
      username: email,
      password: password,
      scope: ''
    })
  });
  const data = await response.json();
  if (data.access_token) {
    localStorage.setItem('access_token', data.access_token);
    localStorage.setItem('refresh_token', data.refresh_token);
    return { success: true, data };
  } else {
    return { success: false, error: data.error_description || 'Unknown error' };
  }
}

export async function getUser() {
  const token = localStorage.getItem('access_token');
  const response = await fetch('http://127.0.0.1:8000/api/user', {
    headers: { 'Authorization': `Bearer ${token}` }
  });
  return await response.json();
}

export async function refreshToken() {
  const refresh_token = localStorage.getItem('refresh_token');
  const response = await fetch('http://127.0.0.1:8000/oauth/token', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      grant_type: 'refresh_token',
      refresh_token: refresh_token || '',
      client_id: '01975a88-3059-7060-baf3-94a1869b048a',
      client_secret: 'lQ6nWW65X6QrnwHi4MfyOaKuzLH5hI2YRK7aWmlg',
      scope: ''
    })
  });
  const data = await response.json();
  if (data.access_token) {
    localStorage.setItem('access_token', data.access_token);
    localStorage.setItem('refresh_token', data.refresh_token);
    return { success: true, data };
  } else {
    return { success: false, error: data.error_description || 'Unknown error' };
  }
}

export function logout() {
  localStorage.removeItem('access_token');
  localStorage.removeItem('refresh_token');
}
