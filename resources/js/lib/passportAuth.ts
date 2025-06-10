export async function login(email: string, password: string) {
  const response = await fetch('http://127.0.0.1:8000/oauth/token', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      grant_type: 'password',
      client_id: '01973d3c-2dc8-72b0-a9bf-16e9d3258237',
      client_secret: '5tBdfzuYTGmNW4tcbp1WaXin4tjygE4qdzEp06ub',
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
      client_id: '01973d3c-2dc8-72b0-a9bf-16e9d3258237',
      client_secret: '5tBdfzuYTGmNW4tcbp1WaXin4tjygE4qdzEp06ub',
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
