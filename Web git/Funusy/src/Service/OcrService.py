import pytesseract
from PIL import Image
import sys
import json
import re

# Path to your Tesseract executable (change this if necessary)
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

def extract_id_number(image_path):
    try:
        # Open the image using PIL (Python Imaging Library)
        with Image.open(image_path) as img:
            # print("Image opened successfully.")  # Print message for debugging
            # Use pytesseract to extract text from the image
            text = pytesseract.image_to_string(img)
            # print("Text extracted from image.")  # Print message for debugging
            # Search for ID numbers starting with 0 or 1 and consisting of 8 digits
            id_numbers = re.findall(r'\b[01]\d{7}\b', text)
            # print("ID numbers extracted:", id_numbers)  # Print extracted ID numbers for debugging
            print(id_numbers[0])  # Print extracted ID numbers for debugging

            # print(json.dumps({'id_numbers': id_numbers}))  # Print the output
    except Exception as e:
        print(f"Error: {e}")
        print(json.dumps({'id_numbers': []}))  # Print an empty list in case of error

if __name__ == "__main__":
    image_path = sys.argv[1]
    extract_id_number(image_path)
