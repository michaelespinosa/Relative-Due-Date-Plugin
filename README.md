# Relative Due Date Plugin

There's not much to document here. It just returns a class based on the given date and current date (Late - date has past, soon - within 5 days, on-time - more than 5 days).

### Requirements:
Expression Engine 1.7

### Plugin Tag:
		{exp:rel_ddate due_date="{custom_entry_date format="%d %F %Y"}"}

### Use:
		<ul>
			<li class="{exp:rel_ddate due_date="{custom_entry_date format="%d %F %Y"}"}">
				Sample to-do
			</ul>
		</ul>

### Output:
		<ul>
			<li class="soon">
				Sample to-do
			</ul>
		</ul>