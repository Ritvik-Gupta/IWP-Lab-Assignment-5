const tasks = document.querySelectorAll("[data-id]")

tasks.forEach(task => {
	task.querySelector(".delete-action").addEventListener("click", async () => {
		const res = await fetch("/task-scheduler/delete-task.php", {
			method: "POST",
			headers: { "Content-Type": "application/json" },
			body: JSON.stringify({ taskId: task.dataset.id }),
		})

		if (res.status != 200) return

		task.remove()
	})

	if (task.classList.contains("expired")) return

	task.addEventListener("dblclick", async () => {
		const isPending = task.classList.contains("pending")

		const res = await fetch("/task-scheduler/update-task.php", {
			method: "POST",
			headers: { "Content-Type": "application/json" },
			body: JSON.stringify({ taskId: task.dataset.id, willBePending: !isPending }),
		})

		if (res.status != 200) return

		task.classList.toggle("pending")
	})
})
