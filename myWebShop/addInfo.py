import json
import os
import random

# Filepath to the JSON file
json_file = os.path.join("myWebShop", "json", "product_new.json")

def load_json(file_path):
    """Load the JSON file or create a new one if it doesn't exist."""
    # Ensure the directory exists
    dir_path = os.path.dirname(file_path)
    if not os.path.exists(dir_path):
        os.makedirs(dir_path)

    # Create the file with an empty product list if it doesn't exist
    if not os.path.exists(file_path):
        with open(file_path, 'w') as file:
            json.dump({"product": []}, file, indent=4)

    # Load the JSON data
    with open(file_path, 'r') as file:
        return json.load(file)

def save_json(file_path, data):
    """Save the updated JSON data back to the file, sorted by pid."""
    # Sort the 'product' list by the 'pid' key
    data['product'] = sorted(data['product'], key=lambda x: x['pid'])
    
    # Save the sorted data to the JSON file
    with open(file_path, 'w') as file:
        json.dump(data, file, indent=4)

def add_product(json_data):
    """Prompt the user to input product details and add it to the product list."""
    done = "x"

    pid = input(f"{'Product ID (pid)':20s}: ").replace("#", "")
    name = input(f"{'Product Name':20s}: ")
    img_src = input(f"{'Image Source':20s}: ")
    desc = input(f"{'Product Description':20s}: ")
    
    # Input price
    price = random.randint(1,100)
    
    # Input type list (iterative input)
    types = []
    print(f"Enter Product Types (enter '{done}' to stop):")
    while True:
        product_type = input(" - ").capitalize()
        if product_type.lower() == done:
            break
        types.append(product_type)
    types.sort()
    
    # Input weakness list (iterative input)
    weaknesses = []
    print(f"Enter Product Weaknesses (enter '{done}' to stop):")
    while True:
        weakness = input(" - ").capitalize()
        if weakness.lower() == done:
            break
        weaknesses.append(weakness)
    weaknesses.sort()
    
    new_product = {
        "pid": pid,
        "name": name,
        "img_src": img_src,
        "desc": desc,
        "price": price,
        "type": types,
        "weakness": weaknesses
    }
    
    json_data['product'].append(new_product)
    print(f"Product #{pid} {name} has been added.")


def reset_product_list(json_data):
    """Reset the product list to an empty list."""
    json_data['product'] = []
    print("Product list has been reset.")

def main():
    # Load existing JSON data
    json_data = load_json(json_file)

    # Define a switch-case-like structure
    switch_case = {
        '1': lambda: add_product(json_data),
        '2': lambda: reset_product_list(json_data),
        '0': lambda: print("Exiting...")
    }

    while True:
        print("="*50)
        print("1. Add New Product")
        print("2. Reset Product List")
        print("0. Exit")
        choice = input("Enter your choice: ")

        # Execute the corresponding function based on the user's choice
        action = switch_case.get(choice)
        if action:
            action()
            if choice != '0':  # Only save and continue if not exiting
                save_json(json_file, json_data)
        else:
            print("Invalid choice. Please try again.")
        
        if choice == '0':
            break

if __name__ == "__main__":
    main()
