/*function.js*/
function generateChart(Type, dataInput, element) {
    const labels = Object.keys(dataInput);
    const values = Object.values(dataInput);
    const ctx = document.getElementById(element).getContext("2d");

    new Chart(ctx, {
        type: "bar", // Loại biểu đồ vẫn là bar (cột)
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Số tiền theo " + Type,
                    data: values,
                    backgroundColor: "rgba(54, 162, 235, 0.6)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                    barThickness: 20, // Độ dày thanh bar
                    maxBarThickness: 20, // Đảm bảo chiều cao không vượt quá 10px
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Đảm bảo không bị ảnh hưởng bởi tỉ lệ
            indexAxis: 'y', // Thay đổi trục x thành trục y
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgba(255, 255, 255, 1)' // Màu chữ của trục Y
                    }
                },
                x: {
                    position: 'top', // Đặt trục X ở phía trên
                    ticks: {
                        color: 'rgba(255, 255, 255, 1)' // Màu chữ của trục X
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgba(255, 255, 255, 1)' // Màu chữ của trục X
                    }
                }
            }
        },
    });
}
