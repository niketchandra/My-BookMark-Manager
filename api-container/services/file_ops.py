import json
from pathlib import Path

DATA_DIR = Path("/data")

def read_json(file):
    with open(DATA_DIR / file) as f:
        return json.load(f)

def write_json(file, data):
    with open(DATA_DIR / file, "w") as f:
        json.dump(data, f, indent=2)
