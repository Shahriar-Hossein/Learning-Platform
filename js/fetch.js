const fetchData = async (url, method = "GET", data = null) => {
    try {
        const options = {
            method,
            headers: { "Content-Type": "application/json" },
            ...(data && { body: JSON.stringify(data) }) // Add body only if data exists
        };

        const response = await fetch(url, options);

        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        return await response.json();
    } catch (error) {
        console.error("Fetch error:", error);
        return { status: "error", message: error.message };
    }
};
