type FetchOptions = {
    method?: 'GET' | 'POST' | 'PUT' | 'DELETE';
    headers?: Record<string, string>;
    body?: any;
};

async function query<T>(url: string, options: FetchOptions = {}): Promise<T | null> {
    const { method = 'GET', headers = {}, body } = options;

    const fetchOptions: RequestInit = {
        method,
        headers: {
            'Content-Type': 'application/json',
            ...headers,
        },
        credentials: 'include',
    };

    if (body) {
        fetchOptions.body = body;
    }

    const response = await fetch(url, fetchOptions);

    if (!response.ok) {
        console.error(`Error: ${response.statusText}`);
        return null;
    }

    return response.json();
}

export default query;